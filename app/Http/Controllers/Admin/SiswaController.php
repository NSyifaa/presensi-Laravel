<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurusanModel;
use App\Models\SiswaModel;
use App\Models\User;
use Illuminate\Http\Request;

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
            'nis' => 'required|integer|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'kelamin' => 'required',
            'alamat' => 'required|required|string|max:255',
            'jurusan' => 'required|string|max:10',
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
            'jurusan' => 'required|string|max:10']);

        SiswaModel::where('nis', $id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
            'kode_jurusan' => $request->jurusan,
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
}
