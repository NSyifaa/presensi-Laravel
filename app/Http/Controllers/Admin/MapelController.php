<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MapelModel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = MapelModel::all();
        return view('admin.mapel', compact('mapel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mapel' => 'required|string|max:255',
        ]);
        
        // Check if the period already exists
        $existingPeriod = MapelModel::where('nama_mapel', $request->mapel)
            ->first();
        
        if ($existingPeriod) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Mapel sudah ada.'
            ]); // HTTP 409: Conflict
        }
        
        MapelModel::create([
            'nama_mapel' => $request->mapel,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Data Mapel telah berhasil ditambahkan.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mapel' => 'required|string|max:255',
        ]);
        
        // Check if the period already exists
        $existingPeriod = MapelModel::where('nama_mapel', $request->mapel)
            ->first();
        
        if ($existingPeriod) {
            return response()->json([
                'status' => 'warning',
                'message' => 'mapel sudah ada.'
            ]); // HTTP 409: Conflict
        }

        MapelModel::where('id', $id)->update([
            'nama_mapel' => $request->mapel,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data mapel telah berhasil diubah.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mapel = MapelModel::where('id', $id);
        if ($mapel) {
            $mapel->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data mapel berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data mapel tidak ditemukan.'
            ]);
        }
    }
}
