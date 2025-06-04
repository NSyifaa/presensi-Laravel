<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\KBMModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruDashController extends Controller
{
    public function index()
    {
        $nip = Auth::user()->username;
        $hariIni = date('l');
        // Ubah nama hari menjadi angka 1-7 (Senin-Minggu)
        $hariMap = [
            'Monday'    => 1,
            'Tuesday'   => 2,
            'Wednesday' => 3,
            'Thursday'  => 4,
            'Friday'    => 5,
            'Saturday'  => 6,
            'Sunday'    => 7,
        ];
        $hariIniAngka = $hariMap[$hariIni] ?? null;

        // Ambil data KBM dengan hari yang sama dengan hari ini
        $kbmHariIni = KBMModel::where('hari', $hariIniAngka)
        ->where('nip', $nip)
        ->get();
        
        return view('guru.dashboard', compact('kbmHariIni', 'hariIniAngka'));
    }

}
