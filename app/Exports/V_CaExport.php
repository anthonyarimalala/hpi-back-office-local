<?php

namespace App\Exports;

use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class V_CaExport implements FromView, WithEvents, WithTitle
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
    public function title(): string
    {
        return 'CA';
    }
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $highestRow = $sheet->getHighestRow() + 10;

                $sheet->getStyle("A11:AA$highestRow")->getFont()->setSize(8);

                $sheet->setCellValue('E5', '=H2/B7');
                $sheet->getStyle('E5')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE_00);

                $colNumbers = ['H', 'J', 'K', 'L', 'M', 'N', '0', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y'];
                foreach ($colNumbers as $colN) {
                    $sheet->getStyle($colN . '11:' . $colN . $highestRow)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                }
                $colDates = ['A', 'AA'];
                foreach ($colDates as $colDate) {
                    $sheet->getStyle($colDate . '11:' . $colDate . $highestRow)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                $columns = range('A', 'Z');
                foreach ($columns as $column) {
                    $sheet->getColumnDimension($column)->setWidth(11.89);
                }
                $event->sheet->getDelegate()->freezePane('A11');

                $sheet->getStyle("A11:AA$highestRow")->getFont()->setSize(8);
            },
        ];
    }
}
