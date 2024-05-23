<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
        }
        .header {
            padding: 20px;
            text-align: center;
            background-color: #3b0764;
            color: #ffffff;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px;
        }
        .content h1 {
            color: #333333;
        }
        .content p {
            color: #666666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #ffffff;
            background-color: #3b0764;
            text-decoration: none;
            border-radius: 5px;
        }
        a {
            text-decoration: none;
            color: #ffffff !important;
        }
        .btn:active, a:active, a:visited {
            color: #ffffff;
        }
        .btn:focus, a:focus {
            color: #ffffff;
        }
        .footer {
            padding: 10px;
            text-align: center;
            background-color: #f4f4f4;
            color: #999999;
            font-size: 12px;
        }
        .empresa {
            margin-top: 20px;
            font-size: 16px;
            color: #666666;
            line-height: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://images2.imgbox.com/6e/63/f4hPU5Yk_o.png" alt="Logo">
        </div>
        <div class="content">
            <h1>Olá, {{ $responsableName }}</h1>
            <p>Você solicitou um link para acessar sua conta. Clique no botão abaixo para prosseguir:</p>
            <a href="{{ $magicLink }}" class="btn">Acessar Conta</a>
            <p class="empresa">
                Educandário das Emoções<br>
                <span style="color: #999999;">https://lp.educandariodasemocoes.com.br/</span>
            </p>

        </div>
        <div class="footer">
            <p>Se você não solicitou este email, por favor, ignore-o.</p>
        </div>
    </div>
</body>
</html>
