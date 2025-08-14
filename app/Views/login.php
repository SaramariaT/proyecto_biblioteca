<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Biblioteca</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #023e8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-contenedor {
            background: white;
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea, #023e8a);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQonzBOsKMupiWBbezX0-Bt8OmK09L3hAoaug&s');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .title {
            color: #333;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        form {
            text-align: left;
        }

        form label {
            display: inline-block;
            color: #555;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        form input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            background: #fff;
            transition: all 0.3s ease;
            outline: none;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        form button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #023e8a 100%);
            color: white;
            border: none;
            padding: 16px 20px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        form button:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #023e8a 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        form button:active {
            transform: translateY(0);
        }

        .error {
            color: #dc3545;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
            text-align: center;
        }

        @media (max-width: 480px) {
            .login-contenedor {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-contenedor">
        <div class="header">
            <div class="logo"></div>
            <h1 class="title">Biblioteca Escolar</h1>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <p class="error"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form action="<?= base_url('login/autenticar') ?>" method="post">
            <label>Usuario:</label><br>
            <input type="text" name="usuario" required><br>
            <label>Contraseña:</label><br>
            <input type="password" name="password" required><br><br>
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>