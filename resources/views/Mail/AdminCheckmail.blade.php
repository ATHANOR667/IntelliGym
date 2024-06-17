<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification de l'e-mail</title>
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #0066cc;
            text-align: center;
        }

        p {
            margin-bottom: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 24px;
        }

        .logo svg {
            width: 100px;
            height: 100px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0066cc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
        }

        .btn:hover {
            background-color: #0052a3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <text x="0" y="15" font-size="18px" font-weight="bold">Intelligym</text>
        </svg>
    </div>
    <h1>Vérification de l'e-mail  Administrateur </h1>
    <p>Merci de vouloir vous inscrire sur notre site ! Avant de pouvoir commencer à utiliser nos services, vous devez d'abord vérifier votre adresse e-mail en cliquant sur le bouton ci-dessous :</p>
    <p><a href="{{route('admin.signin')}}" class="btn">M'inscrire</a></p>
    <p>Si vous n'avez pas tenté de vous inscrire sur notre site, veuillez ignorer cet e-mail.</p>
    <p>Merci,<br>L'équipe d'Intelligym</p>
</div>
</body>
</html>
