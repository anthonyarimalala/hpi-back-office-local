<?php

namespace App\Models\devis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisAppelsEtMail extends Model
{
    use HasFactory;
    protected $table = "devis_appels_et_mails";
    protected $fillable = [
        'id_devis'
    ];
    public static function createDevisAppelsEtMail($id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel, $note_2eme_appel, $date_3eme_appel, $note_3eme_appel, $date_envoi_mail){
        $m_devis_appels_et_mail = DevisAppelsEtMail::firstOrNew(['id_devis' => $id_devis]);
        $m_devis_appels_et_mail->id_devis = $id_devis;
        $m_devis_appels_et_mail->date_1er_appel = $date_1er_appel;
        $m_devis_appels_et_mail->note_1er_appel = $note_1er_appel;
        $m_devis_appels_et_mail->date_2eme_appel = $date_2eme_appel;
        $m_devis_appels_et_mail->note_2eme_appel = $note_2eme_appel;
        $m_devis_appels_et_mail->date_3eme_appel = $date_3eme_appel;
        $m_devis_appels_et_mail->note_3eme_appel = $note_3eme_appel;
        $m_devis_appels_et_mail->date_envoi_mail = $date_envoi_mail;
        $m_devis_appels_et_mail->save();
        return $m_devis_appels_et_mail->id;
    }
}
