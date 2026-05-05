<div class="card">
    <h2>Nuova Fattura</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
    <form method="POST" action="" id="fatturaForm">
        <?php echo Auth::csrfField(); ?>
        <div class="form-group">
            <label>Cliente *</label>
            <select name="cliente_id" id="clienteSelect" required>
                <option value="">Seleziona cliente...</option>
                <?php foreach ($clienti as $c): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['Nome'] . ' ' . $c['Cognome'] . ' (' . $c['Email'] . ')'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Dispositivo *</label>
            <select name="dispositivo_id" id="dispositivoSelect" required>
                <option value="">Seleziona prima un cliente...</option>
            </select>
        </div>
        <div class="form-group">
            <label>Ore Lavoro *</label>
            <input type="number" step="0.5" name="ore_lavoro" min="0.5" required value="1">
        </div>
        <div class="form-group">
            <label>Descrizione</label>
            <textarea name="descrizione" rows="3" placeholder="Descrizione del lavoro effettuato..."></textarea>
        </div>
        <div class="form-group">
            <label>Componenti utilizzati</label>
            <div id="componentiList">
                <?php foreach ($componenti as $comp): ?>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;padding:8px;background:#f9f9f9;border-radius:4px;">
                    <input type="checkbox" name="componenti[]" value="<?php echo $comp['id']; ?>" id="comp_<?php echo $comp['id']; ?>">
                    <label for="comp_<?php echo $comp['id']; ?>" style="flex:1;margin:0;font-size:14px;">
                        <?php echo htmlspecialchars($comp['nome']); ?> - CHF <?php echo number_format($comp['prezzo'], 2); ?>
                        (disp: <?php echo $comp['disponibilita']; ?>)
                    </label>
                    <input type="number" name="quantita[<?php echo $comp['id']; ?>]" placeholder="Q.tà" min="1" value="1" style="width:70px;padding:5px;border:1px solid #ddd;border-radius:4px;">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Crea Fattura</button>
        <a href="<?php echo URL; ?>dipendente/fatture" class="btn btn-primary">Annulla</a>
    </form>
</div>

<script>
document.getElementById('clienteSelect').addEventListener('change', function() {
    var clienteId = this.value;
    var dispSelect = document.getElementById('dispositivoSelect');
    dispSelect.innerHTML = '<option value="">Caricamento...</option>';

    if (clienteId) {
        fetch('<?php echo URL; ?>dipendente/fatture/getDispositiviByCliente?cliente_id=' + clienteId)
            .then(function(r) { return r.json(); })
            .then(function(data) {
                dispSelect.innerHTML = '<option value="">Seleziona dispositivo...</option>';
                data.forEach(function(d) {
                    var opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.nome + ' (' + (d.Modello || 'N/A') + ')';
                    dispSelect.appendChild(opt);
                });
            })
            .catch(function() {
                dispSelect.innerHTML = '<option value="">Errore nel caricamento</option>';
            });
    } else {
        dispSelect.innerHTML = '<option value="">Seleziona prima un cliente...</option>';
    }
});
</script>
