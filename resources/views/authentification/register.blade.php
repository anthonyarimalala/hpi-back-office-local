<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('HPI/logoo-removebg-preview.ico') }}" type="image/x-icon">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <center>
            <img src="{{ asset('HPI/logoo-removebg-preview.png') }}" alt="logo" style="width: 150px; height: auto; object-fit: contain;" />
        </center>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Inscription</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="nom" class="form-control" required>
                        </div>
                        @if($errors->has('nom'))
                            <div class="alert alert-danger">
                                {{ $errors->first('nom') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="prenom">Prenom :</label>
                            <input type="text" id="prenom" name="prenom" class="form-control" required>
                        </div>
                        @if($errors->has('prenom'))
                            <div class="alert alert-danger">
                                {{ $errors->first('prenom') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        @if($errors->has('password'))
                            <div class="alert alert-danger">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="password_confirmation">Confirmation du mot de passe :</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                        @if($errors->has('password_confirmation'))
                            <div class="alert alert-danger">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                        <br><a href="{{ asset('login') }}">Connexion</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
