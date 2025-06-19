<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCEUIL</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        .bg-video {
            position: fixed;
            top: 0;
            left: 0;
            min-width: 100%;
            min-height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
        }

        .logo {
            width: 150px;
            animation: bounce 2s infinite ease-in-out;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .typing {
            font-size: 2rem;
            border-right: 2px solid white;
            white-space: nowrap;
            overflow: hidden;
            width: 0;
            animation:
                typing 4s steps(40, end) forwards,
                blink 0.8s step-end infinite;
            margin-top: 30px;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink {
            50% { border-color: transparent; }
        }

        .enter-btn {
            margin-top: 40px;
            padding: 10px 25px;
            font-size: 1.1rem;
            border: none;
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #2575fc;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .enter-btn:hover {
            background-color: #ffffff;
            transform: scale(1.05);
        }

        /* Bouton pause vidéo */
        .video-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 2;
            background-color: rgba(255, 255, 255, 0.7);
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .video-toggle:hover {
            background-color: #ffffff;
        }
    </style>
</head>
<body>

    <!-- Vidéo de fond -->
    <video autoplay muted loop class="bg-video" id="bgVideo">
        <source src="{{ asset('videos/video.mp4') }}" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo HTML5.
    </video>

    <!-- Bouton pause/lecture -->
    <button class="video-toggle" onclick="toggleVideo()">Pause</button>

    <!-- Contenu -->
    <div class="content">
        <img src="{{ asset('images/img7.png') }}" alt="Logo" class="logo">

        <div class="typing">BIENVENUE SUR LA PLATE-FORME DIGI-STOCK KARDEX</div>

        <a href="{{ route('utilisateur.form') }}">
            <button class="enter-btn">Entrer dans l’application</button>
        </a>
    </div>

    

    <!-- Script JS pour contrôle vidéo -->
    <script>
        const video = document.getElementById('bgVideo');
        const button = document.querySelector('.video-toggle');

        function toggleVideo() {
            if (video.paused) {
                video.play();
                button.textContent = 'Pause';
            } else {
                video.pause();
                button.textContent = 'Lecture';
            }
        }
    </script>

</body>
</html>
