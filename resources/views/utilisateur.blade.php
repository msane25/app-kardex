<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTILISATEUR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh; background-image: url('/images/img20.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center mb-4">CONNEXION</h3>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf

                            <div class="mb-3">

                                    <div class="text-center mb-4">
                                    <img src="{{ asset('images/images4.png') }}" alt="Logo Admin" style="max-height: 100px;">
                                     </div>

                                <label for="email" class="form-label">ADRESSE MAIL</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                          
                           
                        
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                           
                        </form>
           
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
