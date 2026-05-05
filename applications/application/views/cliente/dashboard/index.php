<div class="stats-grid">
    <div class="stat-card">
        <h3><?php echo count($fatture); ?></h3>
        <p>Le tue fatture</p>
    </div>
    <div class="stat-card">
        <h3>CHF <?php echo number_format(array_sum(array_column($fatture, 'prezzo')), 2); ?></h3>
        <p>Totale speso</p>
    </div>
</div>

<div class="card">
    <h2>Le tue ultime fatture</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Dispositivo</th>
            <th>Dipendente</th>
            <th>Prezzo</th>
            <th>Data</th>
            <th>Azioni</th>
        </tr>
        <?php foreach (array_slice($fatture, 0, 5) as $f): ?>
        <tr>
            <td><?php echo $f['id']; ?></td>
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($f['dipendente_nome'] ?? ''); ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($f['data_creazione'])); ?></td>
            <td><a href="<?php echo URL; ?>cliente/fatture/view/<?php echo $f['id']; ?>" class="btn btn-primary btn-sm">Dettaglio</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($fatture)): ?>
        <tr><td colspan="6" class="text-muted" style="text-align:center;">Nessuna fattura presente</td></tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="<?php echo URL; ?>cliente/fatture" class="btn btn-primary">Vedi tutte le fatture</a>
</div>
