<div class="card">
    <h2>Nuovo Cliente</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-row">
            <div class="form-group">
                <label>Nome *</label>
                <input type="text" name="nome" required>
            </div>
            <div class="form-group">
                <label>Cognome *</label>
                <input type="text" name="cognome" required>
            </div>
        </div>
        <div class="form-group">
            <label>Indirizzo</label>
            <input type="text" name="indirizzo">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Telefono</label>
                <input type="text" name="telefono">
            </div>
        </div>
        <div class="form-group">
            <label>Password *</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-success">Crea Cliente</button>
        <a href="<?php echo URL; ?>admin/clienti" class="btn btn-primary">Annulla</a>
    </form>
</div>
