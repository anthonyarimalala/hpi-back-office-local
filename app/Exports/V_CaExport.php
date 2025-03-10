<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class V_CaExport implements FromView, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $praticiens;
    public function __construct($data, $praticiens)
    {
        $this->data = $data;
        $this->praticiens = $praticiens;
    }

    public function view(): View
    {
        //
        return view('export-ca', [
            'data' => $this->data,
            'praticiens' => $this->praticiens,
        ]);
    }
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                /*
                $sheet->setCellValue('B2', 'Total Part Sécu');
                $sheet->setCellValue('C2', '=SUM(J:J)');
                $sheet->setCellValue('D2', '=SUM(J:J)-SUM(K:K)-SUM(L:L)-SUM(N:N)');
                $sheet->setCellValue('E2', '=SUM(L:L)');
                $sheet->setCellValue('F2', '=SUM(M:M)');
                $sheet->setCellValue('G2', '=SUM(N:N)');

                $sheet->setCellValue('B3', 'Total Part Mut');
                $sheet->setCellValue('C3', '=SUM(O:O)');
                $sheet->setCellValue('D3', '=SUM(O:O)-SUM(P:U)');

                $sheet->setCellValue('B4', 'Total Part patient');
                $sheet->setCellValue('C4', '=SUM(V:V)');
                $sheet->setCellValue('D4', '=SUM(V:V)-SUM(W:Y)');
                */

                $sheet->setCellValue('E5', '=H2/B7');
                $sheet->getStyle('E5')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);

                $sheet->getStyle('A11:A'.$sheet->getHighestRow())
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                $colNumbers = array_merge(['H'], range('J', 'Y'));
                foreach ($colNumbers as $col) {
                    $sheet->getStyle($col . '11:' . $col . $sheet->getHighestRow())
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                }

                $columns = range('A', 'Z');
                foreach ($columns as $column) {
                    $sheet->getColumnDimension($column)->setWidth(11.89);
                }
                $event->sheet->getDelegate()->freezePane('A11');
            },
        ];
    }
}
