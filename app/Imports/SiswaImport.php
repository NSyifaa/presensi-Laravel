<?php

namespace App\Imports;

use App\Models\SiswaModel;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class SiswaImport implements ToCollection, ToModel
{
    private $currentRow = 0;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        // dd($collection);
    }
    
    public function model(array $row)
    {
        // dd($row);
        // Skip the first row (header)
        if (count($row) < 7) {
            return null;
        }

        $this->currentRow++;
        if ($this->currentRow > 1) {
            $count = SiswaModel::where('nis', $row[1])->count();
            if (empty($count)) {                
                $user = User::where('username', $row[1])->first();
                if (empty($user)) {
                    // dd($row);
                    $user = new User;
                    $user->username = $row[1];
                    $user->password = bcrypt($row[1]);
                    $user->role = 'siswa';
                    $user->name = $row[2];
                    $user->save();
                }
                $siswa = new SiswaModel;
                $siswa->nis = $row[1];
                $siswa->nama = $row[2];
                $siswa->kelamin = $row[4];
                $siswa->no_hp = $row[5];
                $siswa->alamat = $row[6];
                $siswa->kode_jurusan = $row[3];
                $siswa->save();
            }
        }

        
    }
}
