<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="{{ asset('bootstrap-offline-docs-5.1\dist\css\bootstrap.min.css') }}" rel="stylesheet">
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

                <div class="card-header">Connexion</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="code_u">Code Utilisateur :</label>
                            <input type="text" id="code_u" name="code_u" class="form-control" value="U0001" required>
                            @error('code_u')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe :</label>
                            <input type="password" id="password" name="password" class="form-control" value="anthonyy" required>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Connection</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
