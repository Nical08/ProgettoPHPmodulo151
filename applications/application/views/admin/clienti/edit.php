<div class="card">
    <h2>Modifica Cliente: <?php echo htmlspecialchars($cliente['Nome'] . ' ' . $cliente['Cognome']); ?></h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-row">
            <div class="form-group">
                <label>Nome *</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($cliente['Nome']); ?>" required>
            </div>
            <div class="form-group">
                <label>Cognome *</label>
                <input type="text" name="cognome" value="<?php echo htmlspecialchars($cliente['Cognome']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Indirizzo</label>
            <input type="text" name="indirizzo" value="<?php echo htmlspecialchars($cliente['Indirizzo'] ?? ''); ?>">
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($cliente['Email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Telefono</label>
                <input type="text" name="telefono" value="<?php echo htmlspecialchars($cliente['Telefono'] ?? ''); ?>">
            </div>
        </div>
        <div class="form-group">
            <label>Nuova Password (lascia vuoto per mantenere l'attuale)</label>
            <input type="password" name="password">
        </div>
        <button type="submit" class="btn btn-success">Salva Modifiche</button>
        <a href="<?php echo URL; ?>admin/clienti" class="btn btn-primary">Annulla</a>
    </form>
</div>
