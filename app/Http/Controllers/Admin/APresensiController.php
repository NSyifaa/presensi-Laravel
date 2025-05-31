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
use Mpdf\Mpdf;

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
    public function create(string $id)
    {
        $kbm = KBMModel::with('mapel', 'guru', 'kelas')
            ->where('id', $id)
            ->firstOrFail();

        $presensi = PresensiModel::with('logPresensi.siswa')
        ->where('id_kbm', $id)->get();

        // Log::info($presensi);
        
        return view('admin.presensi._form', compact('presensi', 'kbm'));
    }

    public function pdf(string $id)
    {
        $kbm = KBMModel::with('mapel', 'guru', 'kelas')
            ->where('id', $id)
            ->firstOrFail();

        $presensi = PresensiModel::with('logPresensi.siswa')
        ->where('id_kbm', $id)->get();

        // Susun data seperti di modal, bisa diparsing langsung ke view blade PDF
        $pertemuan = $presensi->count();

        $daftarSiswa = collect();
        foreach ($presensi as $p) {
            foreach ($p->logPresensi as $log) {
                $daftarSiswa->put($log->siswa->nis, $log->siswa);
            }
        }

        $dataPresensi = [];
        foreach ($presensi as $p) {
            foreach ($p->logPresensi as $log) {
                $dataPresensi[$log->siswa->nis][$p->pertemuan_ke] = $log->status;
            }
        }

         $data = [
            'kbm' => $kbm,
            'presensi' => $presensi,
            'pertemuan' => $pertemuan,
            'daftarSiswa' => $daftarSiswa,
            'dataPresensi' => $dataPresensi,
        ];

        // Render view ke HTML
        $html = view('admin.presensi._pdf', $data)->render();

        // Generate PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output ke browser langsung, dengan nama file dinamis
        return $mpdf->Output("Presensi_{$kbm->mapel->nama_mapel}_{$kbm->kelas->nama_kelas}.pdf", 'I');
    }

}
