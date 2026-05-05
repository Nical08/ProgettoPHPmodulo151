<div class="action-bar">
    <h2>Gestione Dipendenti</h2>
    <a href="<?php echo URL; ?>admin/dipendenti/create" class="btn btn-success">+ Nuovo dipendente</a>
</div>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Cerca per nome o email..." value="<?php echo htmlspecialchars($search); ?>">
    <button class="btn btn-primary" onclick="cercaDipendenti()">Cerca</button>
    <?php if ($search): ?>
        <a href="<?php echo URL; ?>admin/dipendenti" class="btn btn-warning">Reset</a>
    <?php endif; ?>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Salario Orario</th>
                <th>Ruolo</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody id="resultsBody">
            <?php foreach ($dipendenti as $d): ?>
            <tr>
                <td><?php echo $d['id']; ?></td>
                <td><?php echo htmlspecialchars($d['nome']); ?></td>
                <td><?php echo htmlspecialchars($d['email']); ?></td>
                <td>CHF <?php echo number_format($d['salario_orario'], 2); ?></td>
                <td><span class="badge badge-<?php echo $d['ruolo'] === 'admin' ? 'admin' : 'dipendente'; ?>"><?php echo htmlspecialchars($d['ruolo']); ?></span></td>
                <td>
                    <a href="<?php echo URL; ?>admin/dipendenti/edit/<?php echo $d['id']; ?>" class="btn btn-primary btn-sm">Modifica</a>
                    <a href="<?php echo URL; ?>admin/dipendenti/delete/<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Eliminare questo dipendente?')">Elimina</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if ($dipendenti->isEmpty()): ?>
            <tr><td colspan="6" class="text-muted" style="text-align:center;">Nessun dipendente trovato</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
var timer = null;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(timer);
    timer = setTimeout(cercaDipendenti, 300);
});

function cercaDipendenti() {
    var q = document.getElementById('searchInput').value;
    if (q.length > 0 && q.length < 2) return;
    fetch('<?php echo URL; ?>admin/dipendenti/apiSearch?q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(data) {
            var tbody = document.getElementById('resultsBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" class="text-muted" style="text-align:center;">Nessun dipendente trovato</td></tr>';
                return;
            }
            var html = '';
            data.forEach(function(d) {
                var badge = d.ruolo === 'admin' ? 'badge-admin' : 'badge-dipendente';
                html += '<tr>' +
                    '<td>' + d.id + '</td>' +
                    '<td>' + esc(d.nome) + '</td>' +
                    '<td>' + esc(d.email) + '</td>' +
                    '<td>CHF ' + parseFloat(d.salario_orario).toFixed(2) + '</td>' +
                    '<td><span class="badge ' + badge + '">' + esc(d.ruolo) + '</span></td>' +
                    '<td>' +
                        '<a href="<?php echo URL; ?>admin/dipendenti/edit/' + d.id + '" class="btn btn-primary btn-sm">Modifica</a> ' +
                        '<a href="<?php echo URL; ?>admin/dipendenti/delete/' + d.id + '" class="btn btn-danger btn-sm" onclick="return confirm(\'Eliminare questo dipendente?\')">Elimina</a>' +
                    '</td></tr>';
            });
            tbody.innerHTML = html;
        });
}

function esc(str) { return str ? str.toString().replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') : ''; }
</script>
