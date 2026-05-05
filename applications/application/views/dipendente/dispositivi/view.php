<div class="card">
    <h2>Dettaglio Dispositivo</h2>
    <table>
        <tr><th style="width:200px;">ID</th><td><?php echo $dispositivo['id']; ?></td></tr>
        <tr><th>Nome</th><td><?php echo htmlspecialchars($dispositivo['nome']); ?></td></tr>
        <tr><th>Modello</th><td><?php echo htmlspecialchars($dispositivo['Modello'] ?? '-'); ?></td></tr>
        <tr><th>Note / Caratteristiche</th><td><?php echo nl2br(htmlspecialchars($dispositivo['note_caratteristiche'] ?? '-')); ?></td></tr>
        <tr><th>Prezzo Nuovo</th><td>CHF <?php echo number_format($dispositivo['Prezzo_nuovo'] ?? 0, 2); ?></td></tr>
        <tr><th>Data Acquisto</th><td><?php echo $dispositivo['Data_acquisto'] ? date('d/m/Y', strtotime($dispositivo['Data_acquisto'])) : '-'; ?></td></tr>
        <tr><th>Data Produzione</th><td><?php echo $dispositivo['Data_produzione'] ? date('d/m/Y', strtotime($dispositivo['Data_produzione'])) : '-'; ?></td></tr>
        <tr><th>Categorie</th>
            <td>
                <?php if (!empty($categorie)): ?>
                    <?php foreach ($categorie as $cat): ?>
                        <span class="badge badge-admin"><?php echo htmlspecialchars($cat['nome_categoria']); ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-muted">Nessuna categoria</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <br>
    <a href="<?php echo URL; ?>dipendente/dispositivi" class="btn btn-primary">Torna all'elenco</a>
</div>
