<?php require_once 'config/config.php';
require_login();
$q = db()->prepare('SELECT * FROM reports WHERE user_id=? ORDER BY created_at DESC');
$q->execute([current_user()['id']]);
$reports = $q->fetchAll();
$pageTitle = 'My reports';
require 'includes/header.php'; ?>
<main class="page-wrap">
    <div class="container">
        <div class="page-heading-row">
            <div>
                <div class="eyebrow dark-eyebrow">YOUR ACTIVITY</div>
                <h1>My incident reports</h1>
                <p class="muted">Review the reports you have submitted and their latest recorded status.</p>
            </div><a class="btn btn-red" href="report.php">＋ New report</a>
        </div><?php if (!$reports): ?><div class="empty-state">
                <div class="empty-icon">▤</div>
                <h2>No reports yet</h2>
                <p>Your submitted incident reports will appear here.</p><a class="btn btn-red" href="report.php">Create your first report</a>
            </div><?php else: ?><div class="report-list"><?php foreach ($reports as $r): ?><article class="report-card">
                        <div class="report-top">
                            <div><span class="report-id">REPORT #<?= (int)$r['id'] ?></span>
                                <h3><?= e($r['location']) ?></h3>
                            </div><span class="status status-<?= e($r['status']) ?>"><?= e(status_label($r['status'])) ?></span>
                        </div>
                        <div class="report-meta"><span>⌖ <?= e($r['fire_type']) ?></span><span>◷ <?= e(date('d M Y, h:i A', strtotime($r['created_at']))) ?></span><span>Severity: <b><?= e($r['severity']) ?></b></span></div>
                        <p><?= e($r['description']) ?></p><?php if ($r['admin_note']): ?><div class="admin-note"><b>Administrator note:</b> <?= e($r['admin_note']) ?></div><?php endif; ?>
                    </article><?php endforeach; ?></div><?php endif; ?>
    </div>
</main><?php require 'includes/footer.php'; ?>