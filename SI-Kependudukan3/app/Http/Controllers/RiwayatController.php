<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $history = HistoryLog::orderBy('created_at', 'desc')->paginate(50);
        return view('riwayat.index', compact('history'));
    }
}
