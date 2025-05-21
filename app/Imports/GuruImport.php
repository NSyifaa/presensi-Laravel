<?php

namespace App\Imports;

use App\Models\GuruModel;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class GuruImport implements ToCollection, ToModel
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
            $count = GuruModel::where('nip', $row[1])->count();
            if (empty($count)) {         
                $user = User::where('username', $row[1])->first();
                if (empty($user)) {
                    // dd($row);
                    $user = new User;
                    $user->username = $row[1];
                    $user->password = bcrypt($row[1]);
                    $user->role = 'guru';
                    $user->name = $row[2];
                    $user->save();
                }       
                $guru = new GuruModel();
                $guru->nip = $row[1];
                $guru->nama = $row[2];
                $guru->kelamin = $row[3];
                $guru->no_hp = $row[4];
                $guru->alamat = $row[5];
                $guru->save();
            }
        }    
    }
}
