<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = GuruModel::get();  
        return view('admin.guru', compact('guru'));
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|unique:guru,nip',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'kelamin' => 'required',
            'alamat' => 'required|required|string|max:255',
        ]);
        
        // Check if the period already exists
        $existingGuru = GuruModel::where('nip', $request->nip)->first();
        if ($existingGuru) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Data Guru sudah ada.'
            ]); 
        }
        
        GuruModel::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
        ]);

        User::create([
            'name' => $request->nama,
            'username' => $request->nip,
            'password' => bcrypt($request->nip),
            'role' => 'guru',
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data guru telah berhasil ditambahkan.'
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
        ]);

        GuruModel::where('nip', $id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'kelamin' => $request->kelamin,
            'alamat' => $request->alamat,
        ]);

        User::where('username', $id)->update([
            'name' => $request->nama,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data guru telah berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user      = User::where('username', $id);
        $guru      = GuruModel::where('nip', $id);
        if ($guru) {
            $user->delete();
            $guru->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data guru berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data guru tidak ditemukan.'
            ]);
        }
    }
    public function download()
    {
        $filePath = 'dokumen/template/templateguru.xls';

        // Pastikan file ada
        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->back()->with('download_error', 'File template tidak ditemukan.');
        }

        $fullPath = Storage::disk('local')->path($filePath);
        return response()->download($fullPath, 'templateguru.xls');
    }

    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xls,xlsx',
        // ]);

        Excel::import(new GuruImport, $request->file('file'));
        return response()->json([
            'status' => 'success',
            'message' => 'Data guru telah berhasil diimport.'
        ]);
    }

    public function resetPassword($nip)
    {
        $guru = User::where('username', $nip)->first();

        if (!$guru) {
            return response()->json(['error' => 'Data guru tidak ditemukan.'], 404);
        }

        $guru->password = bcrypt($nip); 
        $guru->save();

        return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil direset ke default (NIP).',
        ]);
    }
}
