<?php

namespace App\Exports;

use App\Models\JurusanModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle; 
use Maatwebsite\Excel\Concerns\WithStyles; 
use Maatwebsite\Excel\Concerns\WithCustomStartCell; 
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurusanExport implements FromQuery, WithMapping, WithHeadings, WithTitle, WithStyles, WithCustomStartCell

{
    private $rowNumber = 1;

    public function query()
    {
        return JurusanModel::select('kode_jurusan', 'nama_jurusan');
    }

    public function headings(): array
    {
        return [
            'No',
            'KODE JURUSAN',
            'NAMA JURUSAN',
        ];
    }

    public function map($jurusan): array
    {
        return [
            $this->rowNumber++,
            $jurusan->kode_jurusan,
            $jurusan->nama_jurusan,
        ];
    }

    public function title(): string
    {
        return 'Data Jurusan';
    }
    public function styles(Worksheet $sheet): array
    {
        $sheet->setCellValue('A1', 'Data Jurusan');

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
