@extends(session('layout') ?? 'layouts.app')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="home-tab" href="{{ asset($v_prothese->dossier.'/devis/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-controls="overview" aria-selected="false">Devis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#prothese" role="tab" aria-selected="true">Prothèse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" href="{{ asset($v_prothese->dossier.'/cheque/'.$v_prothese->id_devis.'/detail') }}" role="tab" aria-selected="false">Chèque</a>
            </li>
        </ul>
    </div>
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4">Prothèse dossier: </h1>
            <div>
                <a href="">
                    <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button"><i class="mdi mdi-pen"></i>Modifier</button>
                </a>
            </div>
        </div>
    </div>

@endsection
