<?php
namespace App\Exports;

use App\Models\devis\cheque\InfoChequeNatureCheque;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use App\Models\dossier\DossierStatus;
use App\Models\praticien\Praticien;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class V_DevisExport implements FromView, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('orders', [
            'data' => $this->data,
            'dossier_statuss' => DossierStatus::where('is_deleted', 0)->get(), // mes status c'est $dossier_status->status,
            'praticiens' => Praticien::where('is_deleted', 0)->get()
        ]);
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $dossier_statuss = DossierStatus::where('is_deleted', 0)->get()->pluck('status')->toArray(); // Get all statuses
                $praticiens = Praticien::where('is_deleted', 0)->get()->pluck('praticien')->toArray();
                $info_cheques_nature_cheques = InfoChequeNatureCheque::where('is_deleted', 0)->get()->pluck('nature_cheque')->toArray();
                $info_cheques_travaux_sur_devis = InfoChequeTravauxDevis::where('is_deleted', 0)->get()->pluck('travaux_sur_devis')->toArray();
                $info_cheques_situation_cheques = InfoChequeSituationCheque::where('is_deleted', 0)->get()->pluck('situation_cheque')->toArray();

                // Define the range for the dropdown (adjust the range as needed)
                $startRow = 16; // Assuming your data starts from row 16
                $endRow = count($this->data) + 15 + $startRow; // Adjust based on your data count

                // Create a data validation for the dropdown on the specified range
                $range = 'D16:D' . $endRow; // Range D16:D20, for example
                $validation = $event->sheet->getDelegate()->getDataValidation($range);
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setFormula1('"' . implode(',', $dossier_statuss) . '"');
                $validation->setShowDropDown(true);

                $rangeG16 = 'G16:G'.$endRow; // Specify the cell
                $validationG16 = $event->sheet->getDelegate()->getDataValidation($rangeG16);
                $validationG16->setType(DataValidation::TYPE_LIST);
                $validationG16->setFormula1('"oui,non"'); // List with "oui" and "non"
                $validationG16->setShowDropDown(true);

                $rangeH16 = 'H16:H'.$endRow;
                $validationH16 = $event->sheet->getDelegate()->getDataValidation($rangeH16);
                $validationH16->setType(DataValidation::TYPE_LIST);
                $validationH16->setFormula1('"' . implode(',', $praticiens) . '"');
                $validationH16->setShowDropDown(true);

                $rangeAS16 = 'AS16:AS'.$endRow;
                $validationAS16 = $event->sheet->getDelegate()->getDataValidation($rangeAS16);
                $validationAS16->setType(DataValidation::TYPE_LIST);
                $validationAS16->setFormula1('"' . implode(',', $info_cheques_nature_cheques) . '"');
                $validationAS16->setShowDropDown(true);

                $rangeAT16 = 'AT16:AT'.$endRow;
                $validationAT16 = $event->sheet->getDelegate()->getDataValidation($rangeAT16);
                $validationAT16->setType(DataValidation::TYPE_LIST);
                $validationAT16->setFormula1('"' . implode(',', $info_cheques_travaux_sur_devis) . '"');
                $validationAT16->setShowDropDown(true);

                $rangeAU16 = 'AU16:AU'.$endRow;
                $validationAU16 = $event->sheet->getDelegate()->getDataValidation($rangeAU16);
                $validationAU16->setType(DataValidation::TYPE_LIST);
                $validationAU16->setFormula1('"' . implode(',', $info_cheques_situation_cheques) . '"');
                $validationAU16->setShowDropDown(true);


                $sheet = $event->sheet->getDelegate();
                $colNumbers = ['F', 'L', 'M', 'AL', 'AO'];
                foreach ($colNumbers as $col) {
                    $sheet->getStyle($col . '16:' . $col . $sheet->getHighestRow())
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                }
                $colDates = ['E', 'J', 'K', 'N', 'O', 'P', 'Q', 'R', 'T', 'V', 'X', 'Z', 'AA', 'AE', 'AH', 'AJ', 'AM', 'AQ', 'AR'];
                foreach ($colDates as $col){
                    $sheet->getStyle($col . '16:' . $col . $sheet->getHighestRow())
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

            },
        ];
    }





}
