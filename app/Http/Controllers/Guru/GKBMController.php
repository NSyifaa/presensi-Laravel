<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KBMModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class GKBMController extends Controller
{
    public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        
        $kbm = KBMModel::where('id_ta', $taAktif->id)
        ->with(['mapel', 'kelas', 'guru'])
        ->orderBy('hari', 'asc')
        ->get();

        return view('admin.kbm.kbm', compact('kbm','taAktif'));
    }
}
