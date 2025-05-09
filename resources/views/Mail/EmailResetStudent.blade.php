<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Réinitialisation d'adresse mail</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        p {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <svg xmlns="http://www.w3.org/2000/svg" width="400" height="200">
        <text x="20" y="140" font-family="Arial, sans-serif" font-size="120" font-weight="bold" fill="black">
            INTELLIGYM
        </text>
    </svg>
    <h1>Demande De reset d'adresse mail</h1>

    <p>Bonjour,</p>

    <p>Nous avons reçu une demande de modification d'adresse mail  votre part</p>

    <p>
        Veuillez suivre ce lien  : <h2><a href="{{route('user.reset_email',['user' =>\Illuminate\Support\Facades\Crypt::encrypt($student->id)])}}">Reset</a> </h2>
    </p>

    <p>Si vous n'avez pas effectué cette demande, vous pouvez ignorer cet e-mail.</p>

    <p>Merci,<br>L'équipe du college de Paris</p>
</div>
</body>
</html>
