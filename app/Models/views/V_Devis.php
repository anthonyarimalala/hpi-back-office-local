<?php

namespace App\Models\views;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class V_Devis extends Model
{
    use HasFactory;
    protected $table = 'v_devis';


    // Getters & Setters

    // debut- INFO-Cheque
    public function getNumero_cheque()
    {
        if ($this->numero_cheque == null) {
            return '...';
        }
        return $this->numero_cheque;
    }

    public function getMontant_cheque()
    {
        if ($this->montant_cheque == null) {
            return '...';
        }
        return number_format($this->montant_cheque, 2, ',', ' ') . ' €'; // Format monétaire
    }

    public function getNom_document()
    {
        if ($this->nom_document == null) {
            return '...';
        }
        return $this->nom_document;
    }

    public function getDate_encaissement_cheque()
    {
        if ($this->date_encaissement_cheque == null) {
            return '...';
        }
        return Carbon::parse($this->date_encaissement_cheque)->format('d/m/Y');
    }

    public function getDate_1er_acte()
    {
        if ($this->date_1er_acte == null) {
            return '...';
        }
        return Carbon::parse($this->date_1er_acte)->format('d/m/Y');
    }

    public function getNature_cheque()
    {
        if ($this->nature_cheque == null) {
            return '...';
        }
        return $this->nature_cheque;
    }

    public function getTravaux_sur_devis()
    {
        if ($this->travaux_sur_devis == null) {
            return '...';
        }
        return $this->travaux_sur_devis;
    }

    public function getSituation_cheque()
    {
        if ($this->situation_cheque == null) {
            return '...';
        }
        return $this->situation_cheque;
    }

    public function getCheque_observation()
    {
        if ($this->cheque_observation == null) {
            return '...';
        }
        return $this->cheque_observation;
    }

    // fin- INFO-Cheque
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

    public function getPoseStatut()
    {
        if ($this->pose_statut == null) {
            return '...';
        }
        return $this->pose_statut;
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
    public function getMontant(){
        return number_format($this->montant, 2, ',', ' ');
    }
    public function getDate(){
        return Carbon::parse($this->date)->format('d/m/Y');
    }
    public function getDate_envoi_mail(){
        if($this->date_envoi_mail == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_mail)->format('d/m/Y');
    }
    public function getDate_3eme_appel(){
        if ($this->date_3eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_3eme_appel)->format('d/m/Y');
    }
    public function getNote_3eme_appel(){
        if ($this->note_3eme_appel == null){
            return '...';
        }
        return $this->note_3eme_appel;
    }
    public function getDate_2eme_appel(){
        if ($this->date_2eme_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_2eme_appel)->format('d/m/Y');
    }
    public function getNote_2eme_appel(){
        if ($this->note_2eme_appel == null){
            return '...';
        }
        return $this->note_2eme_appel;
    }
    public function getDate_1er_appel(){
        if ($this->date_1er_appel == null){
            return '...';
        }
        return Carbon::parse($this->date_1er_appel)->format('d/m/Y');
    }
    public function getNote_1er_appel(){
        if ($this->note_1er_appel == null){
            return '...';
        }
        return $this->note_1er_appel;
    }
    public function getDate_depot_chq_rac(){
        if($this->date_depot_chq_rac == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_rac)->format('d/m/Y');
    }
    public function getDate_depot_chq_part_mut(){
        if($this->date_depot_chq_part_mut == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_part_mut)->format('d/m/Y');
    }
    public function getDate_depot_chq_pec(){
        if($this->date_depot_chq_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_depot_chq_pec)->format('d/m/Y');
    }
    public function getDate_paiement_cb_ou_esp(){
        if($this->date_paiement_cb_ou_esp == null){
            return '...';
        }
        return Carbon::parse($this->date_paiement_cb_ou_esp)->format('d/m/Y');
    }
    public function getPart_rac(){
        if ($this->part_rac == null){
            return '...';
        }
        return number_format($this->part_rac, 2, ',', ' ');
    }
    public function getPart_mutuelle(){
        if ($this->part_mutuelle == null){
            return '...';
        }
        return number_format($this->part_mutuelle, 2, ',', ' ');
    }
    public function getDate_fin_validite_pec(){
        if ($this->date_fin_validite_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_fin_validite_pec)->format('d/m/Y');
    }
    public function getDate_envoi_pec(){
        if ($this->date_envoi_pec == null){
            return '...';
        }
        return Carbon::parse($this->date_envoi_pec)->format('d/m/Y');
    }
    public function getObservation(){
        if ($this->observation == null){
            return "...";
        }
        return $this->observation;
    }
    public function getPraticien()
    {
        if ($this->praticien == null){
            return "...";
        }
        return $this->praticien;
    }
}
