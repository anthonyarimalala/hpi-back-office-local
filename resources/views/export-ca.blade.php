<table class="table">
    <tr>
        <th></th>
        <th></th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Total</th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Virement <br> en attente</th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Indus payé</th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Indus en attente</th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Indus<br> irrecouvrable</th>
        <th style="background-color: #4285f4; color: whitesmoke; text-align: right; font-size: 7px;">Virement<br> reçu en compte</th>
    </tr>
    <tr>
        <th rowspan="4" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle; background-color: #4285f4; color: whitesmoke; ">BILAN FINANCIER</th>
        <th style="background-color: #f9cb9c; font-size: 7px;">Total Part Sécu</th>
        <td style="background-color: #f9cb9c; text-align: right; ">=SUM(J:J)</td>
        <td style="background-color: #f9cb9c; text-align: right; ">=SUM(J:J)-SUM(K:K)-SUM(L:L)-SUM(N:N)</td>
        <td style="background-color: #f9cb9c; text-align: right; ">=SUM(L:L)</td>
        <td style="background-color: #f9cb9c; text-align: right; ">=SUM(M:M)</td>
        <td style="background-color: #f9cb9c; ">=SUM(N:N)</td>
        <td style="background-color: #d9d9d9; text-align: right; " rowspan="3">=SUM(K:K)+SUM(L:L)+SUM(P:U)+SUM(W:Y)</td>

    </tr>
    <tr>
        <th style="background-color: #cfe2f3; font-size: 7px;">Total Part Mut</th>
        <td style="background-color: #cfe2f3; text-align: right; ">=SUM(O:O)</td>
        <td style="background-color: #cfe2f3; text-align: right; ">=SUM(O:O)-SUM(P:U)</td>
        <td colspan="3" style="background-color: #cfe2f3;"></td>
    </tr>
    <tr>
        <th style="background-color: #d9d2e9; font-size: 7px;">Total Part patient</th>
        <td style="background-color: #d9d2e9; text-align: right; ">=SUM(V:V)</td>
        <td style="background-color: #d9d2e9; text-align: right; ">=SUM(V:V)-SUM(W:Y)</td>
        <td colspan="3" style="background-color: #d9d2e9"></td>
    </tr>
    <tr>
        <!-- L'intitulé du taux d'encaissement, qui s'étend sur trois colonnes -->
        <th colspan="3" style="font-size: 10px; font-weight: bold; background-color: #f3f3f3">
            Taux d'encaissement
        </th>

        <!-- Affichage du taux d'encaissement formaté, qui occupe également trois colonnes et est centré -->
        <td colspan="3" style="text-align: center; font-size: 10px; font-weight: bold; background-color: #f3f3f3">
            <strong></strong>
        </td>

    </tr>
    <tr>
        <th rowspan="2" style="writing-mode: vertical-rl; transform: rotate(180deg); text-align: center; vertical-align: middle; background-color: #fbbc04; color: whitesmoke; ">CA</th>
        <th style="background-color: #fbbc04;  font-weight: bold;">CA Global</th>
        @foreach($praticiens as $pm)
            <th style="background-color: #fbbc04; color: whitesmoke; text-align: right">{{ $pm->praticien }}</th>
        @endforeach
    </tr>
    <tr>
        <td style="text-align: right">=SUM(C2:C4)</td>
        @php
            $colonnes = range('C', 'Z'); // Liste des colonnes possibles
            $index = 0;
        @endphp
        @foreach($praticiens as $pm)
            <td style="text-align: right">=SUMIF($F:$F,{{ $colonnes[$index] }}6,$H:$H)</td>
            @php $index++; @endphp
        @endforeach
    </tr>
    <tr>
        <th colspan="5" style="background-color: #666666; color: whitesmoke; border-right: 2px solid #000; font-size: 10px;">INFOS PATIENTS</th>
        <th colspan="4" style="background-color: #fbbc04; color: whitesmoke; border-right: 2px solid #000; font-size: 10px;">ACTES</th>
        <th colspan="16" style="background-color: #4285f4; color: whitesmoke; border-right: 2px solid #000; font-size: 10px;">REGLEMENTS</th>
        <th colspan="1" style="background-color: #f3f3f3"></th>
    </tr>
    <tr>
        <th colspan="5" style="background-color: #f3f3f3; text-align: center; border-right: 2px solid #000;"></th>
        <th colspan="4" style="background-color: #fff2cc; text-align: center; border-right: 2px solid #000;"></th>
        <th colspan="5" style="background-color: #f9cb9c; text-align: center; border-right: 2px solid #000; font-size: 7px;">RO</th>
        <th colspan="1" style="background-color: #cfe2f3; text-align: center; border-right: 2px solid #000;"></th>
        <th colspan="3" style="background-color: #6d9eeb; text-align: center; border-right: 2px solid #000; font-size: 7px;">RC SOINS</th>
        <th colspan="3" style="background-color: #76a5af; text-align: center; border-right: 2px solid #000; font-size: 7px;">RC soins avec DEVIS</th>
        <th colspan="4" style="background-color: #d9d2e9; text-align: center; border-right: 2px solid #000; font-size: 7px;">RAC</th>
        <th colspan="1" style="background-color: #f3f3f3"></th>
    </tr>
    <tr>
        <th style="background-color: #f3f3f3; font-size: 7px;">Date de dernière modif</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">N° dossier</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Nom du patient</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Statut</th>
        <th style="background-color: #f3f3f3; border-right: 2px solid #000;; font-size: 7px;">Mutuelle</th>
        <th style="background-color: #fff2cc; font-size: 7px;">Praticien</th>
        <th style="background-color: #fff2cc; font-size: 7px;">Acte</th>
        <th style="background-color: #fff2cc; font-size: 7px;">Cotation</th>
        <th style="background-color: #fff2cc; border-right: 2px solid #000;; font-size: 7px;">Contrôle sécurisation</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Part Sécu</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Virement reçu</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Indus payé</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Indus en attente</th>
        <th style="background-color: #f3f3f3; border-right: 2px solid #000;; font-size: 7px;">Indus irrecouvrable</th>
        <th style="background-color: #cfe2f3; border-right: 2px solid #000;; font-size: 7px;">Part Mutuelle</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Virement</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Espèces</th>
        <th style="background-color: #f3f3f3; border-right: 2px solid #000;; font-size: 7px;">CB</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Chèque</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Espèces</th>
        <th style="background-color: #f3f3f3; border-right: 2px solid #000;; font-size: 7px;">CB</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Part patient</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Chèque</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Espèces</th>
        <th style="background-color: #f3f3f3; border-right: 2px solid #000;; font-size: 7px;">CB</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Commentaire</th>
        <th style="background-color: #f3f3f3; font-size: 7px;">Date</th>
    </tr>
    @foreach($data as $ca)
        @php
            $cotation_restant = $ca->cotation - $ca->cotation_paye;
            $part_secu_restant = ($ca->ro_part_secu ?? 0) - $ca->ro_part_secu_paye;
            $part_mutuelle_restant = ($ca->part_mutuelle ?? 0) - $ca->part_mutuelle_paye;
            $rac_part_patient_restant = ($ca->rac_part_patient ?? 0) - $ca->rac_part_patient_paye;
        @endphp
        <tr onclick="window.location.href='{{ asset('ca/'.$ca->id.'/'.$ca->dossier.'/modifier') }}';">
            <td>{{ $ca->date_derniere_modif ? \Carbon\Carbon::parse($ca->date_derniere_modif)->format('d/m/Y') : '' }}</td>
            <td>{{ $ca->dossier }}</td>
            <td>{{ $ca->nom }}</td>
            <td>{{ $ca->statut }}</td>
            <td style="border-right: 2px solid #000; font-size: 8px">{{ $ca->mutuelle }}</td>
            <td>{{ $ca->praticien }}</td>
            <td>{{ $ca->nom_acte }}</td>
            <td style="@if($cotation_restant < 0) background-color: red; @elseif($cotation_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->cotation){{ number_format($ca->cotation, 2, '.', '') }}@endif</td>
            <td style="border-right: 2px solid #000; font-size: 8px">{{ $ca->controle_securisation }}</td>
            <td style="@if($cotation_restant < 0 || $part_secu_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_secu_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->ro_part_secu){{ number_format($ca->ro_part_secu, 2, '.', '') }}@endif</td>
            <td style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->ro_virement_recu){{ number_format($ca->ro_virement_recu, 2, '.', '') }}@endif</td>
            <td style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->ro_indus_paye){{ number_format($ca->ro_indus_paye, 2, '.', '') }}@endif</td>
            <td style="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->ro_indus_en_attente){{ number_format($ca->ro_indus_en_attente, 2, '.', '') }}@endif</td>
            <td class="@if($part_secu_restant < 0) background-color: red; @elseif($part_secu_restant > 0) background-color: orange; @endif text-end" style="border-right: 2px solid #000; font-size: 8px">@if($ca->ro_indus_irrecouvrable){{ number_format($ca->ro_indus_irrecouvrable, 2, '.', '') }}@endif</td>
            <td class="text-end" style="@if($cotation_restant < 0 || $part_mutuelle_restant < 0) background-color: red; @elseif($cotation_restant > 0 || $part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000; ">@if($ca->part_mutuelle){{ number_format($ca->part_mutuelle, 2, '.', '') }}@endif</td>
            <td style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rcs_virement){{ number_format($ca->rcs_virement, 2, '.', '') }}@endif</td>
            <td style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rcs_especes){{ number_format($ca->rcs_especes, 2, '.', '') }}@endif</td>
            <td class="text-end" style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000; ">@if($ca->rcs_cb){{ number_format($ca->rcs_cb, 2, '.', '') }}@endif</td>
            <td style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rcsd_cheque){{ number_format($ca->rcsd_cheque, 2, '.', '') }}@endif</td>
            <td style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rcsd_especes){{ number_format($ca->rcsd_especes, 2, '.', '') }}@endif</td>
            <td style="@if($part_mutuelle_restant < 0) background-color: red; @elseif($part_mutuelle_restant > 0) background-color: orange; @endif border-right: 2px solid #000; " class="text-end">@if($ca->rcsd_cb){{ number_format($ca->rcsd_cb, 2, '.', '') }}@endif</td>
            <td style="@if($cotation_restant < 0 || $rac_part_patient_restant < 0 ) background-color: red; @elseif($cotation_restant > 0 || $rac_part_patient_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rac_part_patient){{ number_format($ca->rac_part_patient, 2, '.', '') }}@endif</td>
            <td style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rac_cheque){{ number_format($ca->rac_cheque, 2, '.', '') }}@endif</td>
            <td style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif " class="text-end">@if($ca->rac_especes){{ number_format($ca->rac_especes, 2, '.', '') }}@endif</td>
            <td class="text-end" style="@if($rac_part_patient_restant < 0) background-color: red; @elseif($rac_part_patient_restant > 0) background-color: orange; @endif border-right: 2px solid #000; ">@if($ca->rac_cb){{ number_format($ca->rac_cb, 2, '.', '') }}@endif</td>
            <td>{{ $ca->commentaire ?: 'Aucun commentaire' }}</td>
            <td>
                @if($ca->created_at)
                    {{ \Carbon\Carbon::parse($ca->created_at)->format('d/m/Y') }}
                @endif
            </td>
        </tr>
    @endforeach
</table>
