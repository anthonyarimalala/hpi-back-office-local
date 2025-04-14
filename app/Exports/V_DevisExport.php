<?php
namespace App\Exports;

use App\Models\devis\cheque\InfoChequeNatureCheque;
use App\Models\devis\cheque\InfoChequeSituationCheque;
use App\Models\devis\cheque\InfoChequeTravauxDevis;
use App\Models\devis\DevisAccordPecStatus;
use App\Models\devis\prothese\ProtheseTravauxStatus;
use App\Models\dossier\DossierStatus;
use App\Models\praticien\Praticien;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Conditional;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class V_DevisExport implements FromView, WithEvents, WithTitle
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
    public function title(): string
    {
        return 'DEVIS & PROTHESE & CHQ';
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
                $prothese_travaux_status = ProtheseTravauxStatus::where('is_deleted', 0)->get()->pluck('travaux_status')->toArray();
                $devis_accord_pecs_status = DevisAccordPecStatus::where('is_deleted', 0)->get()->pluck('status')->toArray();

                // nombre de ligne affecté au dropdown
                $startRow = 16; // Assuming your data starts from row 16
                $endRow = count($this->data) + 15 + $startRow; // Adjust based on your data count

                // dropdown
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

                $rangeM16 = 'M16:M'.$endRow;
                $validationM16 = $event->sheet->getDelegate()->getDataValidation($rangeM16);
                $validationM16->setType(DataValidation::TYPE_LIST);
                $validationM16->setFormula1('"' . implode(',', $devis_accord_pecs_status) . '"');
                $validationM16->setShowDropDown(true);

                $rangeO16 = 'O16:O'.$endRow;
                $validationO16 = $event->sheet->getDelegate()->getDataValidation($rangeO16);
                $validationO16->setType(DataValidation::TYPE_LIST);
                $validationO16->setFormula1('"' . implode(',', $devis_accord_pecs_status) . '"');
                $validationO16->setShowDropDown(true);

                $rangeQ16 = 'Q16:Q'.$endRow;
                $validationQ16 = $event->sheet->getDelegate()->getDataValidation($rangeQ16);
                $validationQ16->setType(DataValidation::TYPE_LIST);
                $validationQ16->setFormula1('"' . implode(',', $devis_accord_pecs_status) . '"');
                $validationQ16->setShowDropDown(true);

                $rangeAP16 = 'AP16:AP'.$endRow;
                $validationAP16 = $event->sheet->getDelegate()->getDataValidation($rangeAP16);
                $validationAP16->setType(DataValidation::TYPE_LIST);
                $validationAP16->setFormula1('"' . implode(',', $prothese_travaux_status) . '"');
                $validationAP16->setShowDropDown(true);

                $rangeAZ16 = 'AZ16:AZ'.$endRow;
                $validationAZ16 = $event->sheet->getDelegate()->getDataValidation($rangeAZ16);
                $validationAZ16->setType(DataValidation::TYPE_LIST);
                $validationAZ16->setFormula1('"' . implode(',', $info_cheques_nature_cheques) . '"');
                $validationAZ16->setShowDropDown(true);

                $rangeBA16 = 'BA16:BA'.$endRow;
                $validationBA16 = $event->sheet->getDelegate()->getDataValidation($rangeBA16);
                $validationBA16->setType(DataValidation::TYPE_LIST);
                $validationBA16->setFormula1('"' . implode(',', $info_cheques_travaux_sur_devis) . '"');
                $validationBA16->setShowDropDown(true);

                $rangeBB16 = 'BB16:BB'.$endRow;
                $validationBB16 = $event->sheet->getDelegate()->getDataValidation($rangeBB16);
                $validationBB16->setType(DataValidation::TYPE_LIST);
                $validationBB16->setFormula1('"' . implode(',', $info_cheques_situation_cheques) . '"');
                $validationBB16->setShowDropDown(true);


                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $colNumbers = ['F', 'L', 'N', 'P', 'R', 'S', 'AI', 'AS', 'AV'];
                foreach ($colNumbers as $col) {
                    $sheet->getStyle($col . '16:' . $col . $highestRow)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);
                }
                $colDates = ['E', 'J', 'K', 'T', 'U', 'V', 'W', 'X', 'Z', 'AB', 'AD', 'AF', 'AG', 'AL', 'AO', 'AQ', 'AT', 'AX', 'AY'];
                foreach ($colDates as $col){
                    $sheet->getStyle($col . '16:' . $col . $highestRow)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                $event->sheet->getDelegate()->freezePane('A16');
                // Appliquer une bordure épaisse sur la ligne verticale entre D et E
                for ($row = 14; $row <= $highestRow; $row++) {
                    $columns = ["E", "I", "J", "N", "R", "Y", "AD", "AE", "AH", "AJ", "AN"];

                    foreach ($columns as $col) {
                        $event->sheet->getDelegate()->getStyle("$col$row")
                            ->getBorders()->getLeft()
                            ->setBorderStyle(Border::BORDER_MEDIUM)
                            ->setColor(new Color(Color::COLOR_BLACK));
                    }
                }

            },
        ];
    }





}
