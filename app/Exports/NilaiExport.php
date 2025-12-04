<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiExport implements FromCollection,WithHeadings,WithStyles,ShouldAutoSize,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nilai::with(['mahasiswa', 'dosen', 'matakuliah'])->get();
    }

    public function map($nilai): array
    {
        return [
            $nilai->mahasiswa->nama ?? '-', // Ambil Nama Mahasiswa
            $nilai->dosen->nama ?? '-',     // Ambil Nama Dosen
            $nilai->matakuliah->nama ?? '-', // Ambil Nama Matkul
            $nilai->nilai_huruf,
            $nilai->nilai_angka,
        ];
    }

    public function headings():array{
        return['mahasiswa','dosen','mata kuliah','nilai_huruf','nilai_angka'];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn=$sheet->getHighestColumn();
        $tableRange='A1:'. $lastColumn . $lastRow;
        $dataRange='A2:'. $lastColumn . $lastRow;

        $sheet->getStyle($tableRange)->applyFromArray([
            'borders'=>[
                'allBorders'=>[
                    'borderStyle'=>Border::BORDER_THIN,
                    'color'=>['argb'=>'000000']
                ]
            ],
            'alignment'=>[
                'vertical'=>Alignment::VERTICAL_CENTER,
            ]
        ]);

        $sheet->getStyle('A1:'. $lastColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true, 
                'size' => 12,
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F4E78'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        for($row=2;$row<=$lastRow;$row++){
            if ($row % 2 == 0) {
                $sheet->getStyle('A' . $row . ':' . $lastColumn . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF2F2F2'],
                    ],
                ]);
            }
        }

        $sheet->getStyle('B2:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C2:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getRowDimension(1)->setRowHeight(25);

        $sheet->setAutoFilter($tableRange);
    }
}
