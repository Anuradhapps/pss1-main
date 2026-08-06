<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class DatabaseBackupController extends Controller
{
    public function download()
    {
        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');

        $filename = $database . '_' . date('Y-m-d_H-i-s') . '.sql';

        $path = storage_path('app/' . $filename);


        // WAMP example path
        $mysqldump = '"C:\wamp64\bin\mysql\mysql8.0.31\bin\mysqldump.exe"';


        $command = "$mysqldump --host=$host --user=$username";


        if (!empty($password)) {
            $command .= " --password=$password";
        }


        $command .= " $database > \"$path\"";


        exec($command, $output, $result);


        if ($result !== 0 || !file_exists($path)) {
            dd([
                'command' => $command,
                'output' => $output,
                'result' => $result
            ]);
        }


        return response()
            ->download($path)
            ->deleteFileAfterSend(true);
    }
}
