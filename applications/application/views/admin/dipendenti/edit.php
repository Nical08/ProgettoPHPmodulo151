<div class="card">
    <h2>Modifica Dipendente: <?php echo htmlspecialchars($dipendente['nome']); ?></h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="">
        <?php echo Auth::csrfField(); ?>
        <div class="form-row">
            <div class="form-group">
                <label>Nome *</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($dipendente['nome']); ?>" required>
            </div>
            <div class="form-group">
                <label>Salario Orario (CHF) *</label>
                <input type="number" step="0.01" name="salario_orario" value="<?php echo $dipendente['salario_orario']; ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email *</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($dipendente['email']); ?>" required>
        </div>
        <div class="form-group">
            <label>Nuova Password (lascia vuoto per mantenere l'attuale)</label>
            <input type="password" name="password">
        </div>
        <div class="form-group">
            <label>Ruolo</label>
            <select name="ruolo">
                <option value="dipendente" <?php echo $dipendente['ruolo'] === 'dipendente' ? 'selected' : ''; ?>>Dipendente</option>
                <option value="admin" <?php echo $dipendente['ruolo'] === 'admin' ? 'selected' : ''; ?>>Amministratore</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Salva Modifiche</button>
        <a href="<?php echo URL; ?>admin/dipendenti" class="btn btn-primary">Annulla</a>
    </form>
</div>
