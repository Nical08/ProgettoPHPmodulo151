<div class="card">
    <h2>Dettaglio Fattura #<?php echo $fattura['id']; ?></h2>
    <table style="margin-bottom:20px;">
        <tr><th style="width:200px;">ID Fattura</th><td><?php echo $fattura['id']; ?></td></tr>
        <tr><th>Data</th><td><?php echo date('d/m/Y H:i', strtotime($fattura['data_creazione'])); ?></td></tr>
        <tr><th>Cliente</th>
            <td>
                <?php if ($fattura['cliente']): ?>
                    <?php echo htmlspecialchars($fattura['cliente']['Nome'] . ' ' . $fattura['cliente']['Cognome']); ?>
                    (<?php echo htmlspecialchars($fattura['cliente']['Email']); ?>)
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
        <tr><th>Dispositivo</th>
            <td>
                <?php if ($fattura['dispositivo']): ?>
                    <?php echo htmlspecialchars($fattura['dispositivo']['nome'] . ' - ' . ($fattura['dispositivo']['Modello'] ?? 'N/A')); ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
        </tr>
        <tr><th>Dipendente</th>
            <td>
                <?php if ($fattura['dipendente']): ?>
                    <?php echo htmlspecialchars($fattura['dipendente']['nome']); ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
            </td>
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
            <th>Prezzo Unitario</th>
            <th>Totale</th>
        </tr>
        <?php $totComp = 0; ?>
        <?php foreach ($fattura['componenti'] as $comp): ?>
        <?php $subtot = $comp['prezzo'] * $comp['quantita']; $totComp += $subtot; ?>
        <tr>
            <td><?php echo htmlspecialchars($comp['nome']); ?></td>
            <td><?php echo $comp['quantita']; ?></td>
            <td>CHF <?php echo number_format($comp['prezzo'], 2); ?></td>
            <td>CHF <?php echo number_format($subtot, 2); ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:600;">Totale componenti:</td>
            <td><strong>CHF <?php echo number_format($totComp, 2); ?></strong></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align:right;font-weight:600;">Mano d'opera (<?php echo $fattura['ore_lavoro']; ?>h):</td>
            <td><strong>CHF <?php echo number_format($fattura['prezzo'] - $totComp, 2); ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
    <br>
    <a href="<?php echo URL; ?>dipendente/fatture" class="btn btn-primary">Torna all'elenco</a>
</div>
