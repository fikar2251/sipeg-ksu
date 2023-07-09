<?php

namespace App\Imports;

use App\Models\Import;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class AbsensiImport implements ToCollection, WithBatchInserts, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function mapping(): array
    {
        return [
            // 'in' => 'H1',
            // 'in' => 'C4',
            // 'in' => 'C5',
            // 'in' => 'C6',
            // 'in' => 'C7',
            // 'in' => 'C8',

        ];
    }

    // public function headingRow(): int
    // {
    //     return 2;
    // }
    public function headingRow(): int
    {
        return 0;
    }
    public function collection(Collection $rows)
    {

        // function startRow(): int
        // {
        //     return 3;
        // }
        $count = 1;

        // foreach ($rows[0] as $key => $row) {
        $total = count($rows[0]);
        $row = $rows[0];
        foreach ($rows as $key => $val) {
            $tot = count($rows);
            for ($j = 3; $j < $tot; $j++) {
                $data[] = [
                    'tanggal' => $row,
                ];
            }
        }
        dd($data);

        $count++;
        // }
        // dd($data);
        die;
    }
    public function model(array $row)
    {
        // if (!is_numeric($row[2])) {
        //   
        // }
        // if (!is_numeric($row[3])) {
        //   
        // }
        // dd($row);
        // }
        // if (is_numeric($row[2])) {
        //     $jam_masuk = $row[2];
        //     $jam_keluar = $row[3];
        //     $nama = $row[1];
        // } else {
        //     $nama = $row[1];
        //     $jam_masuk = '00:00:00';
        //     $jam_keluar = '00:00:00';
        // }
        return new Import([

            // 'nama' => $row[1],
            // 'jam_masuk' => $row[2],
            // 'jam_keluar' => $row[3],
        ]);
    }


    public function batchSize(): int
    {
        return 1000;
    }
}
