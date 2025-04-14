@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6 d-flex flex-column">
            <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card card-rounded">
                        <div class="card-body">
                            <h4 class="card-title card-title-dash mb-0">Changer l'email</h4>
                            <form action="{{ asset('modify/mail') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="mail_name" class="form-label">Nom de l'email</label>
                                    <input type="text" name="mail_name" id="mail_name" class="form-control" placeholder="Nom de l'email" value="{{ \Illuminate\Support\Facades\Auth::user()->mail_name }}" required>
                                    @error('mail_name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="mail" class="form-label">Email</label>
                                    <input type="text" name="mail" id="mail" class="form-control" placeholder="Email" value="{{ \Illuminate\Support\Facades\Auth::user()->mail_sender }}" required>
                                    @error('mail')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="mail_password" class="form-label">Mot de passe d'application (pas votre mot de passe adresse mail)</label>
                                    <input type="password" name="mail_password" id="mail_password" class="form-control" placeholder="Mot de passe" required>
                                    @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary" style="color: whitesmoke">Modifier</button>
                                <br>
                                <a href="#"  data-bs-toggle="modal"
                                   data-bs-target="#etapesModal">Comment ça marche ?</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="etapesModal" tabindex="-1" aria-labelledby="etapesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-12">
                            <div class="steps">
                                <h4 class="text-center">Étapes pour obtenir le mot de passe d'application Gmail</h4>
                                <p></p>
                                <ul class="list-group">
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                            <strong>Étape 1 :</strong> Allez dans "Gérer votre compte Google"
                                        </div>

                                        <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e1.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                            <strong>Étape 2 :</strong> Dans sécurité, cliquez "Validation en deux étapes" et activez cette fonctionnalité
                                        </div>
                                        <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e2.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                            <strong>Étape 3 :</strong> Une fois activé, toujours dans sécurité, vous allez rechecher "Mots de passe des applications" puis cliquer dessus.
                                        </div>
                                        <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e3.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                        <strong>Étape 4 :</strong> Vous pouvez désormais créer un mot de passe d'application, mettez ce que vous voulez pour le nom, celà n'a pas d'importance.
                                        </div>
                                            <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e4.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                        <strong>Étape 5 :</strong> Une fois le nom choisi, une mot de passe d'application est généré(à noter qu'il ne faut pas partager à n'importe qui ce mot de passe d'application), vous allez copier celà.
                                        </div>
                                            <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e5.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                            <strong>Étape 6 :</strong> Il suffit maintenant de mettre le nom de l'email(par exemple, le nom de la société qui envoi l'email), l'email qui envoi(celui où vous avez créer un mot de passe d'application), et enfin coller le mot de passe d'application.
                                        </div>
                                        <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e6.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 mb-12">
                            <h4 class="text-center">Pour supprimer un mot de passe d'application</h4>
                            <p class="text-center" style="background-color: #000000; color: whitesmoke">Une fois que vous avez supprimé un mot de passe d'application. Celui-ci ne marchera plus pour envoyer des emails à partir de l'application.</p>
                            <p class="text-center" style="background-color: #000000; color: whitesmoke">Si vous voulez envoyer des emails après avoir supprimé votre mot de passe d'application, il faudra créer un nouveau mot de passe d'application.</p>
                            <div class="steps">
                                <ul class="list-group">
                                    <li class="list-group-item text-center">
                                        <div style="background-color: #F2CED5">
                                            <strong>Étape :</strong> Après <strong>étape 3</strong>, vous trouverez une liste de vos mots de passe d'application, vous pouvez simplement supprimer maintenant.
                                        </div>

                                        <div class="mt-3">
                                            <img src="{{ asset('etapes-mail/e7.png') }}" alt="Étape 1" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
