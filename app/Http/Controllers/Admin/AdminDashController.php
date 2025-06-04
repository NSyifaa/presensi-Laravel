<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use App\Models\KBMModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;

class AdminDashController extends Controller
{
    public function index()
    {
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
        $kbmHariIni = KBMModel::where('hari', $hariIniAngka)->get();
        $siswa = SiswaModel::all();
        $guru = GuruModel::all();
        $kelas = KelasModel::all();

        return view('admin.dashboard', compact('kbmHariIni', 'siswa', 'guru', 'kelas'));
    }

}
