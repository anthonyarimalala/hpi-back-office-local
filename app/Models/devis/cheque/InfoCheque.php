<?php

namespace App\Models\devis\cheque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoCheque extends Model
{
    use HasFactory;
    protected $table = 'info_cheques';
    protected $fillable = [
        'id_devis',
    ];
    public static function modifierCheque($id_devis, $numero_cheque, $montant_cheque, $nom_document, $date_encaissement_cheque, $date_1er_acte, $nature_cheque, $travaux_sur_devis, $situation_cheque, $observation)
    {
        // Récupérer ou créer une nouvelle instance en fonction de l'id_devis
        $m_cheque = InfoCheque::firstOrNew(['id_devis' => $id_devis]);

        // Mise à jour des valeurs des champs
        $m_cheque->numero_cheque = $numero_cheque;
        $m_cheque->montant_cheque = $montant_cheque;
        $m_cheque->nom_document = $nom_document;
        $m_cheque->date_encaissement_cheque = $date_encaissement_cheque;
        $m_cheque->date_1er_acte = $date_1er_acte;
        $m_cheque->nature_cheque = $nature_cheque;
        $m_cheque->travaux_sur_devis = $travaux_sur_devis;
        $m_cheque->situation_cheque = $situation_cheque;
        $m_cheque->observation = $observation;

        // Sauvegarde dans la base de données
        $m_cheque->save();

        // Retourner l'objet mis à jour
        return $m_cheque;
    }

}
