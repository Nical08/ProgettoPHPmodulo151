<h2>Report e Statistiche</h2>

<div class="stats-grid">
    <div class="stat-card">
        <h3><?php echo $totFatture; ?></h3>
        <p>Fatture totali</p>
    </div>
    <div class="stat-card">
        <h3>CHF <?php echo number_format($totRicavi, 2); ?></h3>
        <p>Ricavi totali</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totClienti; ?></h3>
        <p>Clienti</p>
    </div>
    <div class="stat-card">
        <h3><?php echo $totCategorie; ?></h3>
        <p>Categorie</p>
    </div>
</div>

<div class="card">
    <h2>Tutte le fatture</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Dispositivo</th>
            <th>Dipendente</th>
            <th>Ore</th>
            <th>Prezzo</th>
            <th>Data</th>
        </tr>
        <?php foreach ($fatture as $f): ?>
        <tr>
            <td><?php echo $f['id']; ?></td>
            <td><?php echo htmlspecialchars(($f['cliente_nome'] ?? '') . ' ' . ($f['cliente_cognome'] ?? '')); ?></td>
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($f['dipendente_nome'] ?? ''); ?></td>
            <td><?php echo $f['ore_lavoro']; ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($f['data_creazione'])); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($fatture)): ?>
        <tr><td colspan="7" class="text-muted" style="text-align:center;">Nessuna fattura presente</td></tr>
        <?php endif; ?>
    </table>
</div>
