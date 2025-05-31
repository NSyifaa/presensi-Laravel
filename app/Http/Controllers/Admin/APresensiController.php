<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KBMModel;
use App\Models\KelasJurusanModel;
use App\Models\KelasModel;
use App\Models\PeriodeModel;
use App\Models\PresensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class APresensiController extends Controller
{
    public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();

        $kelas = KelasJurusanModel::with('kbm')
            ->where('id_ta', $taAktif->id)
            ->orderBy('nama_kelas', 'asc')
            ->get();

        return view('admin.presensi.presensi', compact('kelas', 'taAktif'));
    }
    public function kbm($id)
    {
        $kelas = KelasJurusanModel::findOrFail($id);

        $kbm = KBMModel::with('mapel', 'guru', 'tahunAjaran')
            ->where('id_kls_jurusan', $id)
            ->get();
        
        return view('admin.presensi.kbm', compact('kelas', 'kbm'));
    }
    public function create(Request $request, string $id)
    {
        $kbm = KBMModel::with('mapel', 'guru', 'kelas')
            ->where('id', $id)
            ->firstOrFail();

        $presensi = PresensiModel::with('logPresensi.siswa')
        ->where('id_kbm', $id)->get();

        Log::info($presensi);
        
        return view('admin.presensi._form', compact('presensi', 'kbm'));
    }

}
