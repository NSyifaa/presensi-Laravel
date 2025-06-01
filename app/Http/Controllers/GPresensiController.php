<?php

namespace App\Http\Controllers;

use App\Models\KBMModel;
use App\Models\KelasJurusanModel;
use App\Models\PeriodeModel;
use App\Models\PresensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Mpdf;

class GPresensiController extends Controller
{
    public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        $nip = Auth::user()->username;

        $kelas = KelasJurusanModel::with('kbm')
            ->where('id_ta', $taAktif->id)
            ->whereHas('kbm', function ($query) use ($nip) {
                $query->where('nip', $nip);
            })
            ->orderBy('nama_kelas', 'asc')
            ->get();

        return view('guru.presensi.index', compact('kelas', 'taAktif'));
    }
    public function kbm($id)
    {
        $kelas = KelasJurusanModel::findOrFail($id);
        $nip = Auth::user()->username;

        $kbm = KBMModel::with('mapel', 'guru', 'tahunAjaran')
            ->where('id_kls_jurusan', $id)
            ->where('nip', $nip)
            ->get();
        
        return view('guru.presensi.kbm', compact('kelas', 'kbm'));
    }
    public function create(string $id)
    {
        $kbm = KBMModel::with('mapel', 'guru', 'kelas')
            ->where('id', $id)
            ->firstOrFail();

        $presensi = PresensiModel::with('logPresensi.siswa')
        ->where('id_kbm', $id)->get();

        // Log::info($presensi);
        
        return view('guru.presensi._form', compact('presensi', 'kbm'));
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
        $html = view('guru.presensi._pdf', $data)->render();

        // Generate PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output ke browser langsung, dengan nama file dinamis
        return $mpdf->Output("Presensi_{$kbm->mapel->nama_mapel}_{$kbm->kelas->nama_kelas}.pdf", 'I');
    }
}
