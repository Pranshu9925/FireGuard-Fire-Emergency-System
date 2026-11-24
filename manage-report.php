<?php require_once 'config/config.php';
require_admin();
$id = (int)($_GET['id'] ?? 0);
$q = db()->prepare('SELECT r.*,u.name AS reporter,u.email,u.phone FROM reports r JOIN users u ON u.id=r.user_id WHERE r.id=?');
$q->execute([$id]);
$r = $q->fetch();
if (!$r) {
    http_response_code(404);
    exit('Report not found.');
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $status = $_POST['status'] ?? '';
    $note = trim($_POST['admin_note'] ?? '');
    $allowed = ['submitted', 'under_review', 'assigned', 'in_progress', 'resolved'];
    if (!in_array($status, $allowed, true)) $errors[] = 'Select a valid status.';
    if (!$errors) {
        $q = db()->prepare('UPDATE reports SET status=?,admin_note=? WHERE id=?');
        $q->execute([$status, $note, $id]);
        set_flash('Report #' . $id . ' updated.');
        redirect('manage-report.php?id=' . $id);
    }
}
$pageTitle = 'Review report #' . $id;
require 'includes/header.php'; ?>
<main class="page-wrap">
    <div class="container narrow"><a class="back-link" href="dashboard.php">← Back to dashboard</a>
        <div class="page-intro">
            <div class="eyebrow dark-eyebrow">INCIDENT REVIEW · #<?= $id ?></div>
            <h1>Review incident report</h1>
            <p>Review the submitted details and record the latest status.</p>
        </div><?php if ($errors): ?><div class="alert alert-error"><?= e(implode(' ', $errors)) ?></div><?php endif; ?><div class="panel detail-panel">
            <div class="detail-row"><span>Reporter</span><b><?= e($r['reporter']) ?></b></div>
            <div class="detail-row"><span>Email</span><b><?= e($r['email']) ?></b></div>
            <div class="detail-row"><span>Contact</span><b><?= e($r['phone']) ?></b></div>
            <div class="detail-row"><span>Location</span><b><?= e($r['location']) ?><?= $r['area'] ? ' · ' . e($r['area']) : '' ?></b></div>
            <div class="detail-row"><span>Fire type</span><b><?= e($r['fire_type']) ?></b></div>
            <div class="detail-row"><span>Severity</span><b><?= e($r['severity']) ?></b></div>
            <div class="detail-row"><span>Submitted</span><b><?= e(date('d M Y, h:i A', strtotime($r['created_at']))) ?></b></div>
            <div class="detail-description"><span>Description</span>
                <p><?= nl2br(e($r['description'])) ?></p>
            </div>
        </div>
        <form method="post" class="panel form-stack"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="form-section-title"><span>✓</span>
                <div><b>Update report</b><small>Choose the latest status and add an optional note.</small></div>
            </div><label>Incident status<select name="status"><?php foreach (['submitted', 'under_review', 'assigned', 'in_progress', 'resolved'] as $s): ?><option value="<?= e($s) ?>" <?= $r['status'] === $s ? 'selected' : '' ?>><?= e(status_label($s)) ?></option><?php endforeach; ?></select></label><label>Administrator note <span class="optional">(optional)</span><textarea name="admin_note" rows="3" placeholder="Add a short update for the reporter..."><?= e($r['admin_note']) ?></textarea></label><button class="btn btn-red btn-full">Save changes</button>
        </form>
    </div>
</main><?php require 'includes/footer.php'; ?>