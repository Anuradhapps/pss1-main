<?php

namespace App\Http\Controllers;

use App\Exports\ProvinceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export()
    {
        return Excel::download(new ProvinceExport, 'province_data.xlsx');
    }
}
