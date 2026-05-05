<h2>Elenco Dispositivi</h2>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Cerca per nome o modello..." value="<?php echo htmlspecialchars($search); ?>">
    <button class="btn btn-primary" onclick="cercaDispositivi()">Cerca</button>
    <?php if ($search): ?>
        <a href="<?php echo URL; ?>dipendente/dispositivi" class="btn btn-warning">Reset</a>
    <?php endif; ?>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Modello</th>
                <th>Prezzo Nuovo</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody id="resultsBody">
            <?php foreach ($dispositivi as $d): ?>
            <tr>
                <td><?php echo $d['id']; ?></td>
                <td><?php echo htmlspecialchars($d['nome']); ?></td>
                <td><?php echo htmlspecialchars($d['Modello'] ?? '-'); ?></td>
                <td>CHF <?php echo number_format($d['Prezzo_nuovo'] ?? 0, 2); ?></td>
                <td><a href="<?php echo URL; ?>dipendente/dispositivi/view/<?php echo $d['id']; ?>" class="btn btn-primary btn-sm">Dettaglio</a></td>
            </tr>
            <?php endforeach; ?>
            <?php if ($dispositivi->isEmpty()): ?>
            <tr><td colspan="5" class="text-muted" style="text-align:center;">Nessun dispositivo trovato</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
var timer = null;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    timer = setTimeout(cercaDispositivi, 300);
});

function cercaDispositivi() {
    var q = document.getElementById('searchInput').value;
    if (q.length > 0 && q.length < 2) return;
    fetch('<?php echo URL; ?>dipendente/dispositivi/apiSearch?q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var tbody = document.getElementById('resultsBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-muted" style="text-align:center;">Nessun dispositivo trovato</td></tr>';
                return;
            }
            var html = '';
            data.forEach(function(d) {
                html += '<tr>' +
                    '<td>' + d.id + '</td>' +
                    '<td>' + esc(d.nome) + '</td>' +
                    '<td>' + (d.Modello ? esc(d.Modello) : '-') + '</td>' +
                    '<td>CHF ' + parseFloat(d.Prezzo_nuovo || 0).toFixed(2) + '</td>' +
                    '<td><a href="<?php echo URL; ?>dipendente/dispositivi/view/' + d.id + '" class="btn btn-primary btn-sm">Dettaglio</a></td></tr>';
            });
            tbody.innerHTML = html;
        });
}

function esc(str) { return str ? str.toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : ''; }
</script>
