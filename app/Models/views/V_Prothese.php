<?php

namespace App\Models\views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class V_Prothese extends Model
{
    use HasFactory;

    protected $table = 'v_protheses';



    public function getDossier()
    {
        if ($this->dossier == null) {
            return '...';
        }
        return $this->dossier;
    }

    public function getId_devis()
    {
        if ($this->id_devis == null) {
            return '...';
        }
        return $this->id_devis;
    }

    public function getLaboratoire()
    {
        if ($this->laboratoire == null) {
            return '...';
        }
        return $this->laboratoire;
    }

    public function getDate_empreinte()
    {
        if ($this->date_empreinte == null) {
            return '...';
        }
        return Carbon::parse($this->date_empreinte)->format('d/m/Y');
    }

    public function getDate_envoi_labo()
    {
        if ($this->date_envoi_labo == null) {
            return '...';
        }
        return Carbon::parse($this->date_envoi_labo)->format('d/m/Y');
    }

    public function getTravail_demande()
    {
        if ($this->travail_demande == null) {
            return '...';
        }
        return $this->travail_demande;
    }

    public function getNumero_dent()
    {
        if ($this->numero_dent == null) {
            return '...';
        }
        return $this->numero_dent;
    }

    public function getObservations()
    {
        if ($this->observations == null) {
            return '...';
        }
        return $this->observations;
    }

    public function getCreated_at()
    {
        if ($this->created_at == null) {
            return '...';
        }
        return Carbon::parse($this->created_at)->format('d/m/Y');
    }

    public function getUpdated_at()
    {
        if ($this->updated_at == null) {
            return '...';
        }
        return Carbon::parse($this->updated_at)->format('d/m/Y');
    }

    public function getNumero_suivi()
    {
        if ($this->numero_suivi == null) {
            return '...';
        }
        return $this->numero_suivi;
    }

    public function getStatut()
    {
        if ($this->statut == null) {
            return '...';
        }
        return $this->statut;
    }

    public function getOrganisme_payeur()
    {
        if ($this->organisme_payeur == null) {
            return '...';
        }
        return $this->organisme_payeur;
    }

    public function getMontant_encaisse()
    {
        if ($this->montant_encaisse == null) {
            return '...';
        }
        return number_format($this->montant_encaisse, 2, ',', ' ');
    }

    public function getDate_controle_paiement()
    {
        if ($this->date_controle_paiement == null) {
            return '...';
        }
        return Carbon::parse($this->date_controle_paiement)->format('d/m/Y');
    }

    public function getDate_livraison()
    {
        if ($this->date_livraison == null) {
            return '...';
        }
        return Carbon::parse($this->date_livraison)->format('d/m/Y');
    }

    public function getDate_pose_prevue()
    {
        if ($this->date_pose_prevue == null) {
            return '...';
        }
        return Carbon::parse($this->date_pose_prevue)->format('d/m/Y');
    }

    public function getDate_pose_reel()
    {
        if ($this->date_pose_reel == null) {
            return '...';
        }
        return Carbon::parse($this->date_pose_reel)->format('d/m/Y');
    }

    public function getNumero_facture_labo()
    {
        if ($this->numero_facture_labo == null) {
            return '...';
        }
        return $this->numero_facture_labo;
    }



    // Ajoutez d'autres getters pour les autres champs selon besoin
}
