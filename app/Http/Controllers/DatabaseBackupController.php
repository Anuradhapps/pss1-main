<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class DatabaseBackupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function download()
    {
        if (! auth()->check() || ! auth()->user()->hasRole('admin')) {
            abort(403, 'Forbidden');
        }

        $database = Config::get('database.connections.mysql.database');
        $username = Config::get('database.connections.mysql.username');
        $password = Config::get('database.connections.mysql.password');
        $host = Config::get('database.connections.mysql.host');

        if (empty($database) || empty($host)) {
            Log::error('Database backup failed: missing database configuration.');

            return back()->withErrors([
                'backup' => 'The database backup could not be created. Please try again later.',
            ]);
        }

        $filename = $database . '_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $directory = storage_path('app/backups');

        if (! is_dir($directory) && ! mkdir($directory, 0750, true) && ! is_dir($directory)) {
            Log::error('Database backup failed: unable to create backup directory.');

            return back()->withErrors([
                'backup' => 'The database backup could not be created. Please try again later.',
            ]);
        }

        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        $mysqldump = '"C:\\wamp64\\bin\\mysql\\mysql8.0.31\\bin\\mysqldump.exe"';
        $command = "$mysqldump --host=$host --user=$username";

        if (! empty($password)) {
            $command .= ' --password=' . escapeshellarg($password);
        }

        $command .= ' ' . escapeshellarg($database) . ' > ' . escapeshellarg($path);

        exec($command, $output, $result);

        if ($result !== 0 || ! file_exists($path) || ! is_readable($path)) {
            Log::error('Database backup failed.', [
                'database' => '[redacted]',
                'host' => '[redacted]',
                'user' => '[redacted]',
                'result' => $result,
                'output' => '[redacted]',
            ]);

            return back()->withErrors([
                'backup' => 'The database backup could not be created. Please try again later.',
            ]);
        }

        return response()
            ->download($path, $filename, ['Content-Type' => 'application/octet-stream'])
            ->deleteFileAfterSend(true);
    }
}
