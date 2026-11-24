<?php require_once 'config/config.php';
require_admin();
$total = (int)db()->query('SELECT COUNT(*) FROM reports')->fetchColumn();
$open = (int)db()->query("SELECT COUNT(*) FROM reports WHERE status NOT IN ('resolved')")->fetchColumn();
$resolved = (int)db()->query("SELECT COUNT(*) FROM reports WHERE status='resolved'")->fetchColumn();
$users = (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn();
$reports = db()->query('SELECT r.*,u.name AS reporter FROM reports r JOIN users u ON u.id=r.user_id ORDER BY r.created_at DESC')->fetchAll();
$pageTitle = 'Admin dashboard';
require 'includes/header.php'; ?>
<main class="page-wrap">
    <div class="container">
        <div class="page-heading-row">
            <div>
                <div class="eyebrow dark-eyebrow">CONTROL CENTER</div>
                <h1>Admin dashboard</h1>
                <p class="muted">Review submitted incidents and maintain accurate report statuses.</p>
            </div><span class="admin-pill">● ADMIN ACCESS</span>
        </div>
        <div class="stats-grid">
            <div class="stat-card"><span>Total reports</span><strong><?= $total ?></strong><small>All submitted incidents</small></div>
            <div class="stat-card"><span>Open reports</span><strong><?= $open ?></strong><small>Not yet resolved</small></div>
            <div class="stat-card"><span>Resolved</span><strong><?= $resolved ?></strong><small>Marked as resolved</small></div>
            <div class="stat-card"><span>Registered users</span><strong><?= $users ?></strong><small>Portal accounts</small></div>
        </div>
        <div class="table-panel">
            <div class="table-heading">
                <div>
                    <h2>Incident reports</h2>
                    <p>Latest reports submitted through the portal</p>
                </div><span class="table-count"><?= count($reports) ?> records</span>
            </div><?php if (!$reports): ?><div class="empty-state compact">
                    <h3>No incident reports</h3>
                    <p>Reports will appear here after users submit them.</p>
                </div><?php else: ?><div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Report</th>
                                <th>Reporter</th>
                                <th>Location</th>
                                <th>Severity</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody><?php foreach ($reports as $r): ?><tr>
                                    <td><b>#<?= (int)$r['id'] ?></b></td>
                                    <td><?= e($r['reporter']) ?></td>
                                    <td><?= e($r['location']) ?></td>
                                    <td><span class="severity severity-<?= strtolower($r['severity']) ?>"><?= e($r['severity']) ?></span></td>
                                    <td><span class="status status-<?= e($r['status']) ?>"><?= e(status_label($r['status'])) ?></span></td>
                                    <td><?= e(date('d M Y', strtotime($r['created_at']))) ?></td>
                                    <td><a class="table-link" href="manage-report.php?id=<?= (int)$r['id'] ?>">Review →</a></td>
                                </tr><?php endforeach; ?></tbody>
                    </table>
                </div><?php endif; ?>
        </div>
    </div>
</main><?php require 'includes/footer.php'; ?>