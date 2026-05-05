<div class="card">
    <h2>Dettaglio Cliente</h2>
    <table>
        <tr><th style="width:200px;">ID</th><td><?php echo $cliente['id']; ?></td></tr>
        <tr><th>Nome</th><td><?php echo htmlspecialchars($cliente['Nome']); ?></td></tr>
        <tr><th>Cognome</th><td><?php echo htmlspecialchars($cliente['Cognome']); ?></td></tr>
        <tr><th>Indirizzo</th><td><?php echo htmlspecialchars($cliente['Indirizzo'] ?? '-'); ?></td></tr>
        <tr><th>Email</th><td><?php echo htmlspecialchars($cliente['Email']); ?></td></tr>
        <tr><th>Telefono</th><td><?php echo htmlspecialchars($cliente['Telefono'] ?? '-'); ?></td></tr>
    </table>
</div>

<div class="card">
    <h2>Dispositivi del cliente</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Modello</th>
            <th>Prezzo Nuovo</th>
            <th>Azioni</th>
        </tr>
        <?php foreach ($dispositivi as $d): ?>
        <tr>
            <td><?php echo $d['id']; ?></td>
            <td><?php echo htmlspecialchars($d['nome']); ?></td>
            <td><?php echo htmlspecialchars($d['Modello'] ?? '-'); ?></td>
            <td>CHF <?php echo number_format($d['Prezzo_nuovo'] ?? 0, 2); ?></td>
            <td><a href="<?php echo URL; ?>dipendente/dispositivi/view/<?php echo $d['id']; ?>" class="btn btn-primary btn-sm">Dettaglio</a></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($dispositivi)): ?>
        <tr><td colspan="5" class="text-muted" style="text-align:center;">Nessun dispositivo associato</td></tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="<?php echo URL; ?>dipendente/clienti" class="btn btn-primary">Torna all'elenco</a>
</div>
