<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\KBMModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashController extends Controller
{
    public function index()
    {
        $nis = Auth::user()->username;
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

        // Ambil data KBM yang sesuai dengan hari ini dan siswa yang sedang login
        $kbmHariIni = KBMModel::where('hari', $hariIniAngka)
            ->whereHas('kelas.kelasSiswa', function ($query) use ($nis) {
            $query->where('nis', $nis);
            })
            ->get();
        return view('siswa.dashboard', compact('kbmHariIni', 'hariIniAngka'));
    }

}
