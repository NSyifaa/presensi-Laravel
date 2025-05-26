<?php

namespace App\Exports;

use App\Models\SiswaModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiswaExport implements  FromQuery, WithMapping, WithHeadings, WithTitle, WithStyles, WithCustomStartCell
{
   private $rowNumber = 1;

    public function query()
    {
        return SiswaModel::with('jurusan');
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'NAMA SISWA',
            'JURUSAN',
            'NO HP',
            'JENIS KELAMIN',
            'ALAMAT',
        ];
    }

    public function map($siswa): array
    {
        return [
            $this->rowNumber++,
            $siswa->nis,
            $siswa->nama,
            $siswa->jurusan ? $siswa->jurusan->nama_jurusan : 'Tidak ada jurusan',
            $siswa->no_hp,
            $siswa->kelamin,
            $siswa->alamat,
        ];
    }

    public function title(): string
    {
        return 'Data siswa';
    }
    public function styles($sheet): array
    {
        $sheet->setCellValue('A1', 'Data siswa');

        $sheet->mergeCells('A1:F1');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        return [
            3 => ['font' => ['bold' => true], 'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]],
        ];
    }
    

    public function startCell(): string
    {
        return 'A3'; 
    }
}
