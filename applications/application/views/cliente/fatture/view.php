<div class="card">
    <h2>Dettaglio Fattura #<?php echo $fattura['id']; ?></h2>
    <table>
        <tr><th style="width:200px;">ID Fattura</th><td><?php echo $fattura['id']; ?></td></tr>
        <tr><th>Data</th><td><?php echo date('d/m/Y H:i', strtotime($fattura['data_creazione'])); ?></td></tr>
        <tr><th>Dispositivo</th>
            <td><?php echo $fattura['dispositivo'] ? htmlspecialchars($fattura['dispositivo']['nome'] . ' - ' . ($fattura['dispositivo']['Modello'] ?? 'N/A')) : 'N/A'; ?></td>
        </tr>
        <tr><th>Dipendente</th>
            <td><?php echo $fattura['dipendente'] ? htmlspecialchars($fattura['dipendente']['nome']) : 'N/A'; ?></td>
        </tr>
        <tr><th>Ore Lavoro</th><td><?php echo $fattura['ore_lavoro']; ?></td></tr>
        <tr><th>Prezzo Totale</th><td><strong>CHF <?php echo number_format($fattura['prezzo'], 2); ?></strong></td></tr>
        <tr><th>Descrizione</th><td><?php echo nl2br(htmlspecialchars($fattura['descrizione'] ?? '')); ?></td></tr>
    </table>

    <?php if (!empty($fattura['componenti'])): ?>
    <h3>Componenti Utilizzati</h3>
    <table>
        <tr>
            <th>Componente</th>
            <th>Quantità</th>
            <th>Prezzo</th>
        </tr>
        <?php foreach ($fattura['componenti'] as $comp): ?>
        <tr>
            <td><?php echo htmlspecialchars($comp['nome']); ?></td>
            <td><?php echo $comp['quantita']; ?></td>
            <td>CHF <?php echo number_format($comp['prezzo'] * $comp['quantita'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <br>
    <a href="<?php echo URL; ?>cliente/fatture" class="btn btn-primary">Torna all'elenco</a>
</div>
