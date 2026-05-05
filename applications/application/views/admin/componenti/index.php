<div class="action-bar">
    <h2>Gestione Componenti</h2>
    <a href="<?php echo URL; ?>admin/componenti/create" class="btn btn-success">+ Nuovo componente</a>
</div>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Cerca componente..." value="<?php echo htmlspecialchars($search); ?>">
    <button class="btn btn-primary" onclick="cercaComponenti()">Cerca</button>
    <?php if ($search): ?>
        <a href="<?php echo URL; ?>admin/componenti" class="btn btn-warning">Reset</a>
    <?php endif; ?>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Prezzo</th>
                <th>Disponibilità</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody id="resultsBody">
            <?php foreach ($componenti as $c): ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['nome']); ?></td>
                <td>CHF <?php echo number_format($c['prezzo'], 2); ?></td>
                <td><?php echo $c['disponibilita']; ?> pezzi</td>
                <td>
                    <a href="<?php echo URL; ?>admin/componenti/edit/<?php echo $c['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                    <a href="<?php echo URL; ?>admin/componenti/delete/<?php echo $c['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Eliminare questo componente?')">Elimina</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if ($componenti->isEmpty()): ?>
            <tr><td colspan="5" class="text-muted" style="text-align:center;">Nessun componente trovato</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
var timer = null;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    timer = setTimeout(cercaComponenti, 300);
});

function cercaComponenti() {
    var q = document.getElementById('searchInput').value;
    if (q.length > 0 && q.length < 2) return;
    fetch('<?php echo URL; ?>admin/componenti/apiSearch?q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var tbody = document.getElementById('resultsBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-muted" style="text-align:center;">Nessun componente trovato</td></tr>';
                return;
            }
            var html = '';
            data.forEach(function(c) {
                html += '<tr>' +
                    '<td>' + c.id + '</td>' +
                    '<td>' + esc(c.nome) + '</td>' +
                    '<td>CHF ' + parseFloat(c.prezzo).toFixed(2) + '</td>' +
                    '<td>' + c.disponibilita + ' pezzi</td>' +
                    '<td>' +
                        '<a href="<?php echo URL; ?>admin/componenti/edit/' + c.id + '" class="btn btn-primary btn-sm">Modifica</a> ' +
                        '<a href="<?php echo URL; ?>admin/componenti/delete/' + c.id + '" class="btn btn-danger btn-sm" onclick="return confirm(\'Eliminare questo componente?\')">Elimina</a>' +
                    '</td></tr>';
            });
            tbody.innerHTML = html;
        });
}

function esc(str) { return str ? str.toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : ''; }
</script>
