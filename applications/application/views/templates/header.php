<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; color: #333; }
        .header { background: #1a237e; color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 20px; }
        .header .user-info { font-size: 14px; }
        .header .user-info a { color: #90caf9; text-decoration: none; margin-left: 15px; }
        .container { display: flex; min-height: calc(100vh - 60px); }
        .sidebar { width: 250px; background: #283593; color: #fff; padding: 20px 0; }
        .sidebar a { display: block; color: #c5cae9; text-decoration: none; padding: 12px 25px; font-size: 14px; transition: background 0.2s; }
        .sidebar a:hover { background: #3949ab; color: #fff; }
        .sidebar .section-title { padding: 15px 25px 5px; font-size: 11px; text-transform: uppercase; color: #7986cb; letter-spacing: 1px; }
        .content { flex: 1; padding: 30px; }
        .card { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .card h2 { margin-bottom: 20px; color: #1a237e; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f5f5f5; padding: 12px 15px; text-align: left; font-size: 13px; font-weight: 600; color: #555; }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; font-size: 14px; }
        tr:hover td { background: #f8f9ff; }
        .btn { display: inline-block; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-size: 13px; border: none; cursor: pointer; }
        .btn-primary { background: #1a237e; color: #fff; }
        .btn-primary:hover { background: #283593; }
        .btn-success { background: #2e7d32; color: #fff; }
        .btn-success:hover { background: #388e3c; }
        .btn-danger { background: #c62828; color: #fff; }
        .btn-danger:hover { background: #d32f2f; }
        .btn-warning { background: #f57f17; color: #fff; }
        .btn-sm { padding: 5px 10px; font-size: 12px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 5px; color: #555; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #1a237e; outline: none; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .alert { padding: 12px 15px; border-radius: 4px; margin-bottom: 20px; font-size: 14px; }
        .alert-error { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }
        .alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { font-size: 32px; color: #1a237e; margin-bottom: 5px; }
        .stat-card p { font-size: 13px; color: #777; text-transform: uppercase; letter-spacing: 1px; }
        .search-box { display: flex; gap: 10px; margin-bottom: 20px; }
        .search-box input { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .search-box input:focus { border-color: #1a237e; outline: none; }
        .inline { display: inline; }
        .action-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .text-muted { color: #999; font-size: 13px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-admin { background: #e3f2fd; color: #1565c0; }
        .badge-dipendente { background: #e8f5e9; color: #2e7d32; }
        .badge-cliente { background: #fff3e0; color: #e65100; }
    </style>
</head>
<body>
<div class="header">
    <h1><a href="<?php echo URL; ?>" style="color:#fff;text-decoration:none;"><?php echo SITE_NAME; ?></a></h1>
    <div class="user-info">
        <?php if (Auth::isLoggedIn()): ?>
            <span><?php echo htmlspecialchars(Auth::getUserNome()); ?> (<?php echo htmlspecialchars(Auth::getRuolo()); ?>)</span>
            <a href="<?php echo URL; ?>home/logout">Logout</a>
        <?php endif; ?>
    </div>
</div>
<div class="container">
<?php if (Auth::isLoggedIn()): ?>
    <div class="sidebar">
        <?php $ruolo = Auth::getRuolo(); ?>
        <?php if ($ruolo === 'admin'): ?>
            <div class="section-title">Amministrazione</div>
            <a href="<?php echo URL; ?>admin/dashboard">Dashboard</a>
            <a href="<?php echo URL; ?>admin/clienti">Clienti</a>
            <a href="<?php echo URL; ?>admin/dipendenti">Dipendenti</a>
            <a href="<?php echo URL; ?>admin/componenti">Componenti</a>
            <a href="<?php echo URL; ?>admin/report">Report</a>
        <?php elseif ($ruolo === 'dipendente'): ?>
            <div class="section-title">Dipendente</div>
            <a href="<?php echo URL; ?>dipendente/dashboard">Dashboard</a>
            <a href="<?php echo URL; ?>dipendente/fatture">Fatture</a>
            <a href="<?php echo URL; ?>dipendente/dispositivi">Dispositivi</a>
            <a href="<?php echo URL; ?>dipendente/clienti">Clienti</a>
        <?php elseif ($ruolo === 'cliente'): ?>
            <div class="section-title">Cliente</div>
            <a href="<?php echo URL; ?>cliente/dashboard">Dashboard</a>
            <a href="<?php echo URL; ?>cliente/fatture">Le mie fatture</a>
            <a href="<?php echo URL; ?>cliente/profilo">Profilo</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<div class="content">
