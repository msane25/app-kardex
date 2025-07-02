<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTILISATEUR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset("images/img20.jpg") }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .left-section {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            padding: 3rem;
            color: white;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .left-section img {
            max-width: 300px;
            margin-bottom: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        
        .left-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .left-section p {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }
        
        .right-section {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.3) 0%, rgba(30, 64, 175, 0.3) 100%);
            backdrop-filter: blur(10px);
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .login-card {
            background: transparent;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: none;
            width: 100%;
            max-width: 400px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-height: 80px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        h3 {
            color: #333;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .form-control {
            border-radius: 20px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-primary {
            border-radius: 20px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, #764ba2, #667eea);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        
        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .right-section h3,
        .right-section label,
        .right-section .form-label,
        .right-section .alert {
            color: #fff;
        }
        
        .right-section .form-control {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 2px solid #3b82f6;
        }
        
        .right-section .form-control::placeholder {
            color: #e0e7ef;
            opacity: 1;
        }
        
        .right-section .form-control:focus {
            border-color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: rgba(255,255,255,0.25);
            color: #fff;
        }
        
        .right-section .btn-primary {
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            color: #fff;
        }
        
        .right-section .btn-primary:hover {
            background: linear-gradient(45deg, #2563eb, #3b82f6);
            color: #fff;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }
            
            .left-section, .right-section {
                min-height: auto;
                padding: 2rem;
            }
            
            .left-section {
                order: 2;
            }
            
            .right-section {
                order: 1;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Section gauche - Image et textes -->
        <div class="left-section col-lg-6">
            <img src="{{ asset('images/img7.png') }}" alt="Logo Application" id="leftImage">
            <h1 id="mainTitle">Bienvenue dans votre espace</h1>
            <p id="mainText">Connectez-vous pour accéder à votre tableau de bord et gérer vos données en toute sécurité.</p>
            <p id="subText">Système de gestion de stock moderne et intuitif</p>
        </div>

        <!-- Section droite - Formulaire de connexion -->
        <div class="right-section col-lg-6">
            <div class="login-card">
                <h3>CONNEXION</h3>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('utilisateur.login') }}">
                    @csrf

                    <div class="logo-container">
                        <img src="{{ asset('images/img7.png') }}" alt="Logo Admin">
                    </div>

                    <div class="mb-3">
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

    <!-- Script pour permettre la modification des textes et images -->
    <script>
        // Fonction pour modifier l'image de gauche
        function changeLeftImage(newImagePath) {
            document.getElementById('leftImage').src = newImagePath;
        }

        // Fonction pour modifier le titre principal
        function changeMainTitle(newTitle) {
            document.getElementById('mainTitle').textContent = newTitle;
        }

        // Fonction pour modifier le texte principal
        function changeMainText(newText) {
            document.getElementById('mainText').textContent = newText;
        }

        // Fonction pour modifier le sous-texte
        function changeSubText(newText) {
            document.getElementById('subText').textContent = newText;
        }

        // Exemple d'utilisation (vous pouvez appeler ces fonctions depuis la console ou les intégrer dans votre admin)
        // changeLeftImage('/images/nouvelle-image.jpg');
        // changeMainTitle('Nouveau titre');
        // changeMainText('Nouveau texte principal');
        // changeSubText('Nouveau sous-texte');
    </script>
</body>
</html>
