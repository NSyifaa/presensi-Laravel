<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\JurusanModel;
use App\Models\SiswaModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = SiswaModel::with('jurusan')->get();  
        $jurusan = JurusanModel::all();
        return view('admin.siswa', compact('siswa', 'jurusan'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'kelamin' => 'required',
            'alamat' => 'required|required|string|max:255',
            'jurusan' => 'required|string|max:10',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa' => 'required|string|max:100',
        ]);
        
        // Check if the period already exists
        $existingPeriod = SiswaModel::where('nis', $request->nis)->first();
        if ($existingPeriod) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Data siswa sudah ada.'
            ]); 
        }
        
        SiswaModel::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
            'kode_jurusan' => $request->jurusan,
            'provinsi_id' => $request->provinsi_id,
            'provinsi' => $request->provinsi,
            'kabupaten_id' => $request->kabupaten_id,
            'kabupaten' => $request->kabupaten,
            'kecamatan_id' => $request->kecamatan_id,
            'kecamatan' => $request->kecamatan,
            'desa_id' => $request->desa_id,
            'desa' => $request->desa,
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->nis,
            'password' => bcrypt($request->nis),
            'role' => 'siswa',
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data Siswa telah berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'kelamin' => 'required',
            'alamat' => 'required|required|string|max:255',
            'jurusan' => 'required|string|max:10',
            'provinsi' => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa' => 'required|string|max:100',
        ]);

        SiswaModel::where('nis', $id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
            'kode_jurusan' => $request->jurusan,
            'provinsi_id' => $request->provinsi_id,
            'provinsi' => $request->provinsi,
            'kabupaten_id' => $request->kabupaten_id,
            'kabupaten' => $request->kabupaten,
            'kecamatan_id' => $request->kecamatan_id,
            'kecamatan' => $request->kecamatan,
            'desa_id' => $request->desa_id,
            'desa' => $request->desa,
        ]);

        User::where('username', $id)->update([
            'name' => $request->nama,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa telah berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user       = User::where('username', $id);
        $siswa      = SiswaModel::where('nis', $id);
        if ($siswa) {
            $user->delete();
            $siswa->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data siswa berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data siswa tidak ditemukan.'
            ]);
        }
    }

    public function download()
    {
        $filePath = 'dokumen/template/templatesiswa.xls';

        // Pastikan file ada
        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->back()->with('download_error', 'File template tidak ditemukan.');
        }

        $fullPath = Storage::disk('local')->path($filePath);
        // dd($fullPath);
        return response()->download($fullPath, 'templatesiswa.xls');
    }

    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xls,xlsx',
        // ]);

        Excel::import(new SiswaImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data siswa telah berhasil diimport.'
        ]);
    }

    public function export() 
    {
        return Excel::download(new SiswaExport, 'data_siswa.xlsx');
    }

    public function resetPassword($nis)
    {
        $user = User::where('username', $nis)->first();

        if (!$user) {
            return response()->json(['error' => 'Data user tidak ditemukan.'], 404);
        }

        $user->password = bcrypt($nis); 
        $user->save();

        return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil direset ke default (NIS).',
        ]);
    }
}
