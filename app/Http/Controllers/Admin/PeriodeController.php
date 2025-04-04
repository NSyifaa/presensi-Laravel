<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periode = PeriodeModel::All();
        return view('admin.periode', compact('periode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'semester' => 'required|in:1,2',
        ]);
        
        // Check if the period already exists
        $existingPeriod = PeriodeModel::where('tahun', $request->tahun)
            ->where('semester', $request->semester)
            ->first();
        
        if ($existingPeriod) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Periode sudah ada.'
            ]); // HTTP 409: Conflict
        }
        
        PeriodeModel::create([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'T',
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data periode telah berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function aktifkan(Request $request)
    {
        $existingPeriod = PeriodeModel::where('id', $request->id_periode)
        ->first();

        if ($existingPeriod) {
            PeriodeModel::where('status', 'A')->update(['status' => 'T']);
            $existingPeriod->update(['status' => 'A']);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Periode berhasil diaktifkan.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode tidak ditemukan.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periode = PeriodeModel::find($id);
        if ($periode) {
            $periode->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Periode berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Periode tidak ditemukan.'
            ]);
        }
    }
}
