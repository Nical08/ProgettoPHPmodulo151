<div class="card">
    <h2>Modifica Componente: <?php echo htmlspecialchars($componente['nome']); ?></h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-group">
            <label>Nome *</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($componente['nome']); ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Prezzo (CHF) *</label>
                <input type="number" step="0.01" name="prezzo" value="<?php echo $componente['prezzo']; ?>" required>
            </div>
            <div class="form-group">
                <label>Disponibilità (pezzi)</label>
                <input type="number" name="disponibilita" value="<?php echo $componente['disponibilita']; ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Salva Modifiche</button>
        <a href="<?php echo URL; ?>admin/componenti" class="btn btn-primary">Annulla</a>
    </form>
</div>
