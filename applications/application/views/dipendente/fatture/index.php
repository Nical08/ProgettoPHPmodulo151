<h2>Elenco Fatture</h2>
<div style="margin-bottom:20px;">
    <a href="<?php echo URL; ?>dipendente/fatture/create" class="btn btn-success">+ Nuova fattura</a>
</div>

<div class="card">
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Dispositivo</th>
            <th>Dipendente</th>
            <th>Ore</th>
            <th>Prezzo</th>
            <th>Data</th>
            <th>Azioni</th>
        </tr>
        <?php foreach ($fatture as $f): ?>
        <tr>
            <td><?php echo $f['id']; ?></td>
            <td><?php echo htmlspecialchars(($f['cliente_nome'] ?? '') . ' ' . ($f['cliente_cognome'] ?? '')); ?></td>
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($f['dipendente_nome'] ?? ''); ?></td>
            <td><?php echo $f['ore_lavoro']; ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($f['data_creazione'])); ?></td>
            <td><a href="<?php echo URL; ?>dipendente/fatture/view/<?php echo $f['id']; ?>" class="btn btn-primary btn-sm">Dettaglio</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($fatture)): ?>
        <tr><td colspan="8" class="text-muted" style="text-align:center;">Nessuna fattura presente</td></tr>
        <?php endif; ?>
    </table>
</div>
