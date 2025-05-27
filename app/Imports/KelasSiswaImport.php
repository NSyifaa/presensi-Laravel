<?php

namespace App\Imports;

use App\Models\KelasSiswaModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class KelasSiswaImport implements ToCollection, ToModel
{
    protected $id;

    private $currentRow = 0;
    /**
    * @param Collection $collection
    */
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection(Collection $collection)
    {
        
    }
    
    public function model(array $row)
    {
        // dd($row );
        // dd($this->id);
        // if (count($row) < 2) {
        //     return null;
        // }

        $this->currentRow++;
        if ($this->currentRow > 1) {
            Log::info('Row: ' . json_encode($this->id));

            $count = KelasSiswaModel::where('nis', $row[1])
            ->where('id_kls_jurusan', $this->id)
            ->count();
            if (empty($count)) {         
                $kelasSiswa = new KelasSiswaModel();
                $kelasSiswa->id_kls_jurusan = $this->id;
                $kelasSiswa->nis =  $row[1];
                $kelasSiswa->save();
            } 
        }    
    }
}
