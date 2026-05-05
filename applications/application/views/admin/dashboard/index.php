<div class="stats-grid">
    <div class="stat-card">
        <h3><?php echo $totClienti; ?></h3>
        <p>Clienti</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totDipendenti; ?></h3>
        <p>Dipendenti</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totDispositivi; ?></h3>
        <p>Dispositivi</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totFatture; ?></h3>
        <p>Fatture emesse</p>
    </div>
    <div class="stat-card">
        <h3>CHF <?php echo number_format($totRicavi, 2); ?></h3>
        <p>Ricavi totali</p>
    </div>
</div>

<div class="card">
    <h2>Ultime fatture</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Dispositivo</th>
            <th>Dipendente</th>
            <th>Prezzo</th>
            <th>Data</th>
        </tr>
        <?php foreach (array_slice($ultimeFatture, 0, 10) as $f): ?>
        <tr>
            <td><?php echo $f['id']; ?></td>
            <td><?php echo htmlspecialchars(($f['cliente_nome'] ?? '') . ' ' . ($f['cliente_cognome'] ?? '')); ?></td>
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($f['dipendente_nome'] ?? ''); ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($f['data_creazione'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($ultimeFatture)): ?>
        <tr><td colspan="6" class="text-muted" style="text-align:center;">Nessuna fattura presente</td></tr>
        <?php endif; ?>
    </table>
</div>
