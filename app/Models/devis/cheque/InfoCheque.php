<?php

namespace App\Models\devis\cheque;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoCheque extends Model
{
    use HasFactory;
    protected $table = 'info_cheques';
    protected $fillable = [
        'id_devis',
    ];
    public static function modifierCheque($m_h_cheque, $id_devis, $numero_cheque, $montant_cheque, $nom_document, $date_encaissement_cheque, $date_1er_acte, $nature_cheque, $travaux_sur_devis, $situation_cheque, $observation, &$withChangeCheque = false)
    {
        $m_cheque = InfoCheque::firstOrNew(['id_devis' => $id_devis]);

        if ($m_cheque->numero_cheque != $numero_cheque) {
            $m_h_cheque->action .= "<strong>Numero cheque:</strong> " . $m_cheque->numero_cheque . " => " . $numero_cheque . "\n";
            $m_cheque->numero_cheque = $numero_cheque;
            $withChangeCheque = true;
        }

        if ($m_cheque->montant_cheque != $montant_cheque) {
            $m_h_cheque->action .= "<strong>Montant cheque:</strong> " . $m_cheque->montant_cheque . " => " . $montant_cheque . "\n";
            $m_cheque->montant_cheque = $montant_cheque;
            $withChangeCheque = true;
        }

        if ($m_cheque->nom_document != $nom_document) {
            $m_h_cheque->action .= "<strong>Nom document:</strong> " . $m_cheque->nom_document . " => " . $nom_document . "\n";
            $m_cheque->nom_document = $nom_document;
            $withChangeCheque = true;
        }

        if (($m_cheque->date_encaissement_cheque ? Carbon::parse($m_cheque->date_encaissement_cheque)->format('Y-m-d'):'') != $date_encaissement_cheque) {
            $m_h_cheque->action .= "<strong>Date encaissement cheque:</strong> " . ($m_cheque->date_encaissement_cheque ? Carbon::parse($m_cheque->date_encaissement_cheque)->format('d-m-Y'):'...') . " => " . ($date_encaissement_cheque? Carbon::parse($date_encaissement_cheque)->format('d-m-Y'):'...') . "\n";
            $m_cheque->date_encaissement_cheque = $date_encaissement_cheque;
            $withChangeCheque = true;
        }

        if (($m_cheque->date_1er_acte ? Carbon::parse($m_cheque->date_1er_acte)->format('Y-m-d') : '') != $date_1er_acte) {
            $m_h_cheque->action .= "<strong>Date 1er acte:</strong> " . ($m_cheque->date_1er_acte ? Carbon::parse($m_cheque->date_1er_acte)->format('d-m-Y') : '...') . " => " . ($date_1er_acte ? Carbon::parse($date_1er_acte)->format('d-m-Y'):'...') . "\n";
            $m_cheque->date_1er_acte = $date_1er_acte;
            $withChangeCheque = true;
        }

        if ($m_cheque->nature_cheque != $nature_cheque) {
            $m_h_cheque->action .= "<strong>Nature cheque:</strong> " . $m_cheque->nature_cheque . " => " . $nature_cheque . "\n";
            $m_cheque->nature_cheque = $nature_cheque;
            $withChangeCheque = true;
        }

        if ($m_cheque->travaux_sur_devis != $travaux_sur_devis) {
            $m_h_cheque->action .= "<strong>Travaux sur devis:</strong> " . $m_cheque->travaux_sur_devis . " => " . $travaux_sur_devis . "\n";
            $m_cheque->travaux_sur_devis = $travaux_sur_devis;
            $withChangeCheque = true;
        }

        if ($m_cheque->situation_cheque != $situation_cheque) {
            $m_h_cheque->action .= "<strong>Situation cheque:</strong> " . $m_cheque->situation_cheque . " => " . $situation_cheque . "\n";
            $m_cheque->situation_cheque = $situation_cheque;
            $withChangeCheque = true;
        }

        if ($m_cheque->observation != $observation) {
            $m_h_cheque->action .= "<strong>Observation:</strong> " . $m_cheque->observation . " => " . $observation . "\n";
            $m_cheque->observation = $observation;
            $withChangeCheque = true;
        }



        $m_cheque->save();

        return $m_cheque;
    }

}
