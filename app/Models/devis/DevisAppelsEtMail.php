<?php

namespace App\Models\devis;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisAppelsEtMail extends Model
{
    use HasFactory;
    protected $table = "devis_appels_et_mails";
    protected $fillable = [
        'id_devis'
    ];

    public static function createDevisAppelsEtMailDate_Non_Automatic($m_h_devis, $id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel = null, $note_2eme_appel = null, $date_3eme_appel = null, $note_3eme_appel = null, $date_envoi_mail = null, &$withChange = false){
        // Conversion de la date du 1er appel en DateTime si nécessaire
        if ($date_1er_appel && !($date_1er_appel instanceof \DateTime)) {
            $date_1er_appel = new \DateTime($date_1er_appel);
        }

        // Création ou mise à jour du modèle
        $m_devis_appels_et_mail = DevisAppelsEtMail::firstOrNew(['id_devis' => $id_devis]);
        $m_devis_appels_et_mail->id_devis = $id_devis;
        if (($m_devis_appels_et_mail->date_1er_appel ? Carbon::parse($m_devis_appels_et_mail->date_1er_appel)->format('Y-m-d') : '') != ($date_1er_appel instanceof \DateTime ? $date_1er_appel->format('Y-m-d') : $date_1er_appel)) {
            $m_h_devis->action .= "<strong>Date 1er appel:</strong> " . ($m_devis_appels_et_mail->date_1er_appel ? Carbon::parse($m_devis_appels_et_mail->date_1er_appel)->format('d-m-Y') : '...') . " => " . ($date_1er_appel ? Carbon::parse($date_1er_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_1er_appel = $date_1er_appel instanceof \DateTime ? $date_1er_appel->format('Y-m-d') : $date_1er_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_1er_appel != $note_1er_appel) {
            $m_h_devis->action .= "<strong>Note 1er appel:</strong> " . $m_devis_appels_et_mail->note_1er_appel . " => " . $note_1er_appel . "\n";
            $m_devis_appels_et_mail->note_1er_appel = $note_1er_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_2eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_2eme_appel)->format('Y-m-d') : '') != $date_2eme_appel) {
            $m_h_devis->action .= "<strong>Date 2eme appel:</strong> " . ($m_devis_appels_et_mail->date_2eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_2eme_appel)->format('d-m-Y') : '...') . " => " . ($date_2eme_appel ? Carbon::parse($date_2eme_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_2eme_appel = $date_2eme_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_2eme_appel != $note_2eme_appel) {
            $m_h_devis->action .= "<strong>Note 2eme appel:</strong> " . $m_devis_appels_et_mail->note_2eme_appel . " => " . $note_2eme_appel . "\n";
            $m_devis_appels_et_mail->note_2eme_appel = $note_2eme_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_3eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_3eme_appel)->format('Y-m-d') : '') != $date_3eme_appel) {
            $m_h_devis->action .= "<strong>Date 3eme appel:</strong> " . ($m_devis_appels_et_mail->date_3eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_3eme_appel)->format('d-m-Y') : '...') . " => " . ($date_3eme_appel ? Carbon::parse($date_3eme_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_3eme_appel = $date_3eme_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_3eme_appel != $note_3eme_appel) {
            $m_h_devis->action .= "<strong>Note 3eme appel:</strong> " . $m_devis_appels_et_mail->note_3eme_appel . " => " . $note_3eme_appel . "\n";
            $m_devis_appels_et_mail->note_3eme_appel = $note_3eme_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_envoi_mail ? Carbon::parse($m_devis_appels_et_mail->date_envoi_mail)->format('Y-m-d') : '') != $date_envoi_mail) {
            $m_h_devis->action .= "<strong>Date envoi mail:</strong> " . ($m_devis_appels_et_mail->date_envoi_mail ? Carbon::parse($m_devis_appels_et_mail->date_envoi_mail)->format('d-m-Y') : '...') . " => " . ($date_envoi_mail ? Carbon::parse($date_envoi_mail)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_envoi_mail = $date_envoi_mail;
            $withChange = true;
        }

        $m_devis_appels_et_mail->save();

        return $m_devis_appels_et_mail->id;
    }

    public static function createDevisAppelsEtMail($m_h_devis, $id_devis, $date_1er_appel, $note_1er_appel, $date_2eme_appel = null, $note_2eme_appel = null, $date_3eme_appel = null, $note_3eme_appel = null, $date_envoi_mail = null, &$withChange = false, $email_sent = null) {
        $m_devis_appels_et_mail = DevisAppelsEtMail::firstOrNew(['id_devis' => $id_devis]);
        if ($m_devis_appels_et_mail->date_1er_appel == null || $m_devis_appels_et_mail->date_1er_appel == ''){
            // Conversion de la date du 1er appel en DateTime si nécessaire
            if ($date_1er_appel && !($date_1er_appel instanceof \DateTime)) {
                $date_1er_appel = new \DateTime($date_1er_appel);
            }

            // Calcul des dates par défaut uniquement si le 1er appel est défini
            if ($date_1er_appel) {
                if (!$date_2eme_appel) {
                    $date_2eme_appel = clone $date_1er_appel;
                    $date_2eme_appel->modify('+2 days');
                } elseif (!($date_2eme_appel instanceof \DateTime)) {
                    $date_2eme_appel = new \DateTime($date_2eme_appel);
                }

                if (!$date_3eme_appel) {
                    $date_3eme_appel = clone $date_2eme_appel;
                    $date_3eme_appel->modify('+3 days');
                } elseif (!($date_3eme_appel instanceof \DateTime)) {
                    $date_3eme_appel = new \DateTime($date_3eme_appel);
                }

                if (!$date_envoi_mail) {
                    $date_envoi_mail = clone $date_3eme_appel;
                } elseif (!($date_envoi_mail instanceof \DateTime)) {
                    $date_envoi_mail = new \DateTime($date_envoi_mail);
                }

                // Conversion des objets DateTime en string pour stockage
                $date_2eme_appel = $date_2eme_appel->format('Y-m-d');
                $date_3eme_appel = $date_3eme_appel->format('Y-m-d');
                $date_envoi_mail = $date_envoi_mail->format('Y-m-d');
            }

        }

        // Création ou mise à jour du modèle

        $m_devis_appels_et_mail->id_devis = $id_devis;
        if (($m_devis_appels_et_mail->date_1er_appel ? Carbon::parse($m_devis_appels_et_mail->date_1er_appel)->format('Y-m-d') : '') != ($date_1er_appel instanceof \DateTime ? $date_1er_appel->format('Y-m-d') : $date_1er_appel)) {
            $m_h_devis->action .= "<strong>Date 1er appel:</strong> " . ($m_devis_appels_et_mail->date_1er_appel ? Carbon::parse($m_devis_appels_et_mail->date_1er_appel)->format('d-m-Y') : '...') . " => " . ($date_1er_appel ? Carbon::parse($date_1er_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_1er_appel = $date_1er_appel instanceof \DateTime ? $date_1er_appel->format('Y-m-d') : $date_1er_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_1er_appel != $note_1er_appel) {
            $m_h_devis->action .= "<strong>Note 1er appel:</strong> " . $m_devis_appels_et_mail->note_1er_appel . " => " . $note_1er_appel . "\n";
            $m_devis_appels_et_mail->note_1er_appel = $note_1er_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_2eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_2eme_appel)->format('Y-m-d') : '') != $date_2eme_appel) {
            $m_h_devis->action .= "<strong>Date 2eme appel:</strong> " . ($m_devis_appels_et_mail->date_2eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_2eme_appel)->format('d-m-Y') : '...') . " => " . ($date_2eme_appel ? Carbon::parse($date_2eme_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_2eme_appel = $date_2eme_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_2eme_appel != $note_2eme_appel) {
            $m_h_devis->action .= "<strong>Note 2eme appel:</strong> " . $m_devis_appels_et_mail->note_2eme_appel . " => " . $note_2eme_appel . "\n";
            $m_devis_appels_et_mail->note_2eme_appel = $note_2eme_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_3eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_3eme_appel)->format('Y-m-d') : '') != $date_3eme_appel) {
            $m_h_devis->action .= "<strong>Date 3eme appel:</strong> " . ($m_devis_appels_et_mail->date_3eme_appel ? Carbon::parse($m_devis_appels_et_mail->date_3eme_appel)->format('d-m-Y') : '...') . " => " . ($date_3eme_appel ? Carbon::parse($date_3eme_appel)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_3eme_appel = $date_3eme_appel;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->note_3eme_appel != $note_3eme_appel) {
            $m_h_devis->action .= "<strong>Note 3eme appel:</strong> " . $m_devis_appels_et_mail->note_3eme_appel . " => " . $note_3eme_appel . "\n";
            $m_devis_appels_et_mail->note_3eme_appel = $note_3eme_appel;
            $withChange = true;
        }

        if (($m_devis_appels_et_mail->date_envoi_mail ? Carbon::parse($m_devis_appels_et_mail->date_envoi_mail)->format('Y-m-d') : '') != $date_envoi_mail) {
            $m_h_devis->action .= "<strong>Date envoi mail:</strong> " . ($m_devis_appels_et_mail->date_envoi_mail ? Carbon::parse($m_devis_appels_et_mail->date_envoi_mail)->format('d-m-Y') : '...') . " => " . ($date_envoi_mail ? Carbon::parse($date_envoi_mail)->format('d-m-Y') : '...') . "\n";
            $m_devis_appels_et_mail->date_envoi_mail = $date_envoi_mail;
            $withChange = true;
        }

        if ($m_devis_appels_et_mail->email_sent != $email_sent) {
            $m_h_devis->action .= "<strong>Email envoyé</strong> " . "\n";
            $m_devis_appels_et_mail->email_sent = $email_sent;
            $withChange = true;
        }

        $m_devis_appels_et_mail->save();

        return $m_devis_appels_et_mail->id;
    }

}
