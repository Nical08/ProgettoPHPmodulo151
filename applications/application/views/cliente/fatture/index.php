<h2>Le mie fatture</h2>

<div class="card">
    <table>
        <tr>
            <th>ID</th>
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
            <td><?php echo htmlspecialchars($f['dispositivo_nome'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($f['dipendente_nome'] ?? ''); ?></td>
            <td><?php echo $f['ore_lavoro']; ?></td>
            <td>CHF <?php echo number_format($f['prezzo'], 2); ?></td>
            <td><?php echo date('d/m/Y', strtotime($f['data_creazione'])); ?></td>
            <td><a href="<?php echo URL; ?>cliente/fatture/view/<?php echo $f['id']; ?>" class="btn btn-primary btn-sm">Dettaglio</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($fatture)): ?>
        <tr><td colspan="7" class="text-muted" style="text-align:center;">Nessuna fattura presente</td></tr>
        <?php endif; ?>
    </table>
</div>
