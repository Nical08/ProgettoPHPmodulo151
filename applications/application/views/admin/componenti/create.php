<div class="card">
    <h2>Nuovo Componente</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-group">
            <label>Nome *</label>
            <input type="text" name="nome" required>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Prezzo (CHF) *</label>
                <input type="number" step="0.01" name="prezzo" required>
            </div>
            <div class="form-group">
                <label>Disponibilità (pezzi)</label>
                <input type="number" name="disponibilita" value="0">
            </div>
        </div>
        <button type="submit" class="btn btn-success">Crea Componente</button>
        <a href="<?php echo URL; ?>admin/componenti" class="btn btn-primary">Annulla</a>
    </form>
</div>
