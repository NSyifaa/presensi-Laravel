<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\LogPresensiModel;
use App\Models\PresensiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function index()
    {
        return view('siswa.presensi');
    }

    public function presensi(string $id)
    {
        
        $presensi = PresensiModel::find($id);
        if (!$presensi) {
            return redirect()->route('siswa.presensi')->with('error', 'Presensi tidak ditemukan.');
        }
            
        if ($presensi->ket == 'A') {

            $nis = Auth::user()->username;
            $log = LogPresensiModel::where('id_presensi', $id)
            ->where('nis', $nis)
            ->first();

            $statusLog = $log->status;
            if ($statusLog == 'Hadir') {
                return response()->json([
                'status' => 'warning',
                'message' => 'Anda sudah melakukan presensi pertemuan ini.'
                ]);
            } else {
                $log->status = 'Hadir';
                $log->save();
                return response()->json([
                'status' => 'success',
                'message' => 'Presensi berhasil dilakukan.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'warning',
                'message' => 'Presensi sudah ditutup.'
                ]);
        }
    }   
}
