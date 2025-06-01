<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\KelasSiswaImport;
use App\Models\JurusanModel;
use App\Models\KelasJurusanModel;
use App\Models\KelasSiswaModel;
use App\Models\PeriodeModel;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class KelasJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        $kelas = KelasJurusanModel::with(['jurusan', 'kelas', 'tahunAjaran', 'kelasSiswa'])
            ->where('id_ta', $taAktif->id)
            ->get();
        $jurusan = JurusanModel::all();

        return view('admin.kelas_jurusan.kelas_jurusan', compact('kelas', 'jurusan', 'taAktif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:10',
            'kode_kelas' => 'required|string|max:10',
        ]);
        
        // Check if the period already exists
        $existingPeriod = KelasJurusanModel::where('nama_kelas', $request->nama)->first();
        if ($existingPeriod) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Data Kelas sudah ada.'
            ]); 
        }

        $taAktif = PeriodeModel::where('status', 'A')->first();
        if (!$taAktif) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada tahun ajaran aktif.'
            ]);
        }

        KelasJurusanModel::create([
            'nama_kelas' => $request->nama,
            'kode_jurusan' => $request->kode_jurusan,
            'kode_kelas' => $request->kode_kelas,
            'id_ta' => $taAktif->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data Kelas telah berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:10',
            'kode_kelas' => 'required|string|max:10',
        ]);
        
        $taAktif = PeriodeModel::where('status', 'A')->first();
        if (!$taAktif) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak ada tahun ajaran aktif.'
            ]);
        }

        KelasJurusanModel::where('id', $id)->update([
            'nama_kelas' => $request->nama,
            'kode_jurusan' => $request->kode_jurusan,
            'kode_kelas' => $request->kode_kelas,
            'id_ta' => $taAktif->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data kelas telah berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas      = KelasJurusanModel::where('id', $id);
        if ($kelas) {
            $kelas->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data kelas berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data kelas tidak ditemukan.'
            ]);
        }
    }

    public function detail(string $id)
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        $kelas = KelasJurusanModel::with(['jurusan', 'kelas', 'tahunAjaran'])
            ->where('id', $id)
            ->first();

        $kelasSiswa = KelasSiswaModel::where('id_kls_jurusan', $id)
        ->with('siswa')
        ->get();
        // log::info($kelas);
        $siswa = SiswaModel::all();
        return view('admin.kelas_jurusan.kelas_jurusan_detail', compact('kelas', 'kelasSiswa','siswa'));
    }

    public function addSiswa(Request $request, string $id)
    {
        $request->validate([
            'nis' => 'required',
        ]);

        $kelasSiswa = KelasSiswaModel::where('id_kls_jurusan', $id)
            ->where('nis', $request->nis)
            ->first();
        
            if ($kelasSiswa) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Data siswa sudah terdaftar.'
            ]);
        }
        
        KelasSiswaModel::create([
            'id_kls_jurusan' => $id,
            'nis' => $request->nis,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa telah berhasil ditambahkan.'
        ]);
    }

    public function download()
    {
        $filePath = 'dokumen/template/template_siswa_kls.xls';

        // Pastikan file ada
        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->back()->with('download_error', 'File template tidak ditemukan.');
        }

        $fullPath = Storage::disk('local')->path($filePath);
        // dd($fullPath);
        return response()->download($fullPath, 'template_siswa_kls.xls');
    }

    public function import(Request $request, string $id)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xls,xlsx',
        // ]);

        Log::info('Importing file for Kelas ID: ' . $id);
        
        Excel::import(new KelasSiswaImport($id), $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa telah berhasil diimport.'
        ]);
    }
}
