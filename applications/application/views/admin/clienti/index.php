<div class="action-bar">
    <h2>Gestione Clienti</h2>
    <a href="<?php echo URL; ?>admin/clienti/create" class="btn btn-success">+ Nuovo cliente</a>
</div>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Cerca per nome, cognome, email o telefono..." value="<?php echo htmlspecialchars($search); ?>">
    <button class="btn btn-primary" onclick="cercaClienti()">Cerca</button>
    <?php if ($search): ?>
        <a href="<?php echo URL; ?>admin/clienti" class="btn btn-warning">Reset</a>
    <?php endif; ?>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th>Telefono</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody id="resultsBody">
            <?php foreach ($clienti as $c): ?>
            <tr>
                <td><?php echo $c['id']; ?></td>
                <td><?php echo htmlspecialchars($c['Nome']); ?></td>
                <td><?php echo htmlspecialchars($c['Cognome']); ?></td>
                <td><?php echo htmlspecialchars($c['Email']); ?></td>
                <td><?php echo htmlspecialchars($c['Telefono'] ?? '-'); ?></td>
                <td>
                    <a href="<?php echo URL; ?>admin/clienti/edit/<?php echo $c['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                    <a href="<?php echo URL; ?>admin/clienti/delete/<?php echo $c['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Eliminare questo cliente?')">Elimina</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if ($clienti->isEmpty()): ?>
            <tr><td colspan="6" class="text-muted" style="text-align:center;">Nessun cliente trovato</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
var timer = null;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    timer = setTimeout(cercaClienti, 300);
});

function cercaClienti() {
    var q = document.getElementById('searchInput').value;
    if (q.length > 0 && q.length < 2) return;
    fetch('<?php echo URL; ?>admin/clienti/apiSearch?q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var tbody = document.getElementById('resultsBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-muted" style="text-align:center;">Nessun cliente trovato</td></tr>';
                return;
            }
            var html = '';
            data.forEach(function(c) {
                html += '<tr>' +
                    '<td>' + c.id + '</td>' +
                    '<td>' + esc(c.Nome) + '</td>' +
                    '<td>' + esc(c.Cognome) + '</td>' +
                    '<td>' + esc(c.Email) + '</td>' +
                    '<td>' + (c.Telefono ? esc(c.Telefono) : '-') + '</td>' +
                    '<td>' +
                        '<a href="<?php echo URL; ?>admin/clienti/edit/' + c.id + '" class="btn btn-primary btn-sm">Modifica</a> ' +
                        '<a href="<?php echo URL; ?>admin/clienti/delete/' + c.id + '" class="btn btn-danger btn-sm" onclick="return confirm(\'Eliminare questo cliente?\')">Elimina</a>' +
                    '</td></tr>';
            });
            tbody.innerHTML = html;
        });
}

function esc(str) { return str ? str.toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;') : ''; }
</script>
