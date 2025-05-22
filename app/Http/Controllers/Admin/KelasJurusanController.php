<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurusanModel;
use App\Models\KelasJurusanModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KelasJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        $kelas = KelasJurusanModel::with(['jurusan', 'kelas', 'periode'])
            ->where('id_ta', $taAktif->id)
            ->get();
        $jurusan = JurusanModel::all();

        return view('admin.kelas_jurusan.kelas_jurusan', compact('kelas', 'jurusan'));
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
        $kelas = KelasJurusanModel::with(['jurusan', 'kelas', 'periode'])
            ->where('id', $id)
            ->first();

        log::info($kelas);
        return view('admin.kelas_jurusan.kelas_jurusan_detail', compact('kelas'));
    }
}
