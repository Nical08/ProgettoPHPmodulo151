<div class="stats-grid">
    <div class="stat-card">
        <h3><?php echo count($totFatture); ?></h3>
        <p>Fatture create</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totDispositivi; ?></h3>
        <p>Dispositivi in riparazione</p>
    </div>
</div>

<div class="card">
    <h2>Le tue ultime fatture</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Dispositivo</th>
            <th>Ore</th>
            <th>Prezzo</th>
            <th>Data</th>
        </tr>
        <?php foreach (array_slice($totFatture, 0, 5) as $f): ?>
        <tr>
            <td><?php echo $f['id']; ?></td>
            <td><?php echo htmlspecialchars(($f['cliente_nome'] ?? '') . ' ' . ($f['cliente_cognome'] ?? '')); ?></td>
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo $f['ore_lavoro']; ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($f['data_creazione'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($totFatture)): ?>
        <tr><td colspan="6" class="text-muted" style="text-align:center;">Nessuna fattura creata</td></tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="<?php echo URL; ?>dipendente/fatture" class="btn btn-primary">Vedi tutte le fatture</a>
    <a href="<?php echo URL; ?>dipendente/fatture/create" class="btn btn-success">Nuova fattura</a>
</div>
