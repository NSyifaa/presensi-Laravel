<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuruModel;
use App\Models\KBMModel;
use App\Models\KelasJurusanModel;
use App\Models\MapelModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class KBMController extends Controller
{
     public function index()
    {
        $taAktif = PeriodeModel::where('status', 'A')->first();
        
        $kbm = KBMModel::where('id_ta', $taAktif->id)
        ->with(['mapel', 'kelas', 'guru'])
        ->orderBy('hari', 'asc')
        ->get();

        $guru   = GuruModel::all();
        $mapel  = MapelModel::all();
        $kelas  = KelasJurusanModel::all();

        return view('admin.kbm.kbm', compact('kbm','taAktif','guru', 'mapel', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel'  => 'required|exists:mapel,id',
            'kode_kelas'  => 'required|exists:ta_kelas_jurusan,id',
            'nip'       => 'required|exists:guru,nip',
            'hari'      => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
           ]);

        // Validate that the start time is before the end time
        if ($request->jam_mulai >= $request->jam_selesai) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Jam mulai harus sebelum jam selesai.'
            ]);
        }

        // Check if the period already exists
        $existingKBM = KBMModel::where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('jam_selesai', $request->jam_selesai)
            ->where('id_mapel', $request->kode_mapel)
            ->where('id_kls_jurusan', $request->kode_kelas)
            ->where('nip', $request->nip)
            ->first();

        if ($existingKBM) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Data KBM sudah ada / jadwak KBM bertabrakan.'
            ]); 
        }
    
        $taAktif = PeriodeModel::where('status', 'A')->first();
        if (!$taAktif) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Tidak ada tahun ajaran aktif.'
            ]);
        }

        KBMModel::create([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'id_mapel' => $request->kode_mapel,
            'id_kls_jurusan' => $request->kode_kelas,
            'nip' => $request->nip,
            'id_ta' => $taAktif->id,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data KBM telah berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kode_mapel'  => 'required|exists:mapel,id',
            'kode_kelas'  => 'required|exists:ta_kelas_jurusan,id',
            'nip'       => 'required|exists:guru,nip',
            'hari'      => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // Validate that the start time is before the end time
        if ($request->jam_mulai >= $request->jam_selesai) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jam mulai harus sebelum jam selesai.'
            ]);
        }
         
        KBMModel::where('id', $id)->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'id_mapel' => $request->kode_mapel,
            'id_kls_jurusan' => $request->kode_kelas,
            'nip' => $request->nip,
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Data KBM telah berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kbm      = KBMModel::where('id', $id);
        if ($kbm->exists()) {
            $kbm->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data KBM berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data KBM tidak ditemukan.'
            ]);
        }
    }
}
