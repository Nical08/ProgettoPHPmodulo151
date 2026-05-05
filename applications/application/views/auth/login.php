<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo SITE_NAME; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #1a237e; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-box { background: #fff; border-radius: 8px; padding: 40px; width: 400px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
        .login-box h1 { font-size: 24px; color: #1a237e; margin-bottom: 5px; }
        .login-box p { font-size: 14px; color: #777; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #555; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group input:focus { border-color: #1a237e; outline: none; }
        .btn { width: 100%; padding: 12px; background: #1a237e; color: #fff; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #283593; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .alert-error { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
    </style>
</head>
<body>
<div class="login-box">
    <h1><?php echo SITE_NAME; ?></h1>
    <p>Accedi al sistema di gestione</p>
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Inserisci la tua email" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Inserisci la password" required>
        </div>
        <button type="submit" class="btn">Accedi</button>
    </form>
</div>
</body>
</html>
