<?php require_once 'config/config.php';
require_login();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $location = trim($_POST['location'] ?? '');
    $area = trim($_POST['area'] ?? '');
    $type = $_POST['fire_type'] ?? '';
    $severity = $_POST['severity'] ?? '';
    $description = trim($_POST['description'] ?? '');
    $allowedTypes = ['Electrical', 'Kitchen', 'Building', 'Vehicle', 'Forest / Outdoor', 'Other'];
    $allowedSeverity = ['Low', 'Medium', 'High', 'Critical'];
    if ($location === '') $errors[] = 'Incident location is required.';
    if (!in_array($type, $allowedTypes, true)) $errors[] = 'Select a valid fire type.';
    if (!in_array($severity, $allowedSeverity, true)) $errors[] = 'Select a valid severity.';
    if (strlen($description) < 10) $errors[] = 'Description must be at least 10 characters.';
    if (!$errors) {
        $q = db()->prepare('INSERT INTO reports(user_id,location,area,fire_type,severity,description) VALUES(?,?,?,?,?,?)');
        $q->execute([current_user()['id'], $location, $area, $type, $severity, $description]);
        $id = db()->lastInsertId();
        set_flash('Report #' . $id . ' submitted successfully.');
        redirect('my-reports.php');
    }
}
$pageTitle = 'Report an incident';
require 'includes/header.php'; ?>
<main class="page-wrap">
    <div class="container narrow">
        <div class="page-intro">
            <div class="eyebrow dark-eyebrow">INCIDENT INTAKE</div>
            <h1>Report a fire incident</h1>
            <p>Share accurate details so the incident information can be reviewed. If there is immediate danger, move to safety and contact emergency services directly.</p>
        </div><?php if ($errors): ?><div class="alert alert-error"><?= e(implode(' ', $errors)) ?></div><?php endif; ?><form method="post" class="panel form-stack"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="form-section-title"><span>01</span>
                <div><b>Location details</b><small>Where is the incident happening?</small></div>
            </div><label>Incident location *<input name="location" required maxlength="255" placeholder="Street, area, city or landmark" value="<?= e($_POST['location'] ?? '') ?>"></label><label>Building / area details <span class="optional">(optional)</span><input name="area" maxlength="150" placeholder="Floor, apartment, office, nearby landmark" value="<?= e($_POST['area'] ?? '') ?>"></label>
            <div class="form-section-title"><span>02</span>
                <div><b>Incident information</b><small>Describe what you know about the fire.</small></div>
            </div>
            <div class="two-col"><label>Fire type *<select name="fire_type" required>
                        <option value="">Select fire type</option><?php foreach (['Electrical', 'Kitchen', 'Building', 'Vehicle', 'Forest / Outdoor', 'Other'] as $v): ?><option <?= (($_POST['fire_type'] ?? '') === $v ? 'selected' : '') ?>><?= e($v) ?></option><?php endforeach; ?>
                    </select></label><label>Severity *<select name="severity" required>
                        <option value="">Select severity</option><?php foreach (['Low', 'Medium', 'High', 'Critical'] as $v): ?><option <?= (($_POST['severity'] ?? '') === $v ? 'selected' : '') ?>><?= e($v) ?></option><?php endforeach; ?>
                    </select></label></div><label>Incident description *<textarea name="description" required minlength="10" rows="5" placeholder="Describe the situation and any important details..."><?= e($_POST['description'] ?? '') ?></textarea></label>
            <div class="form-footnote">Your account contact details will be associated with this report. Submit only information you believe to be accurate.</div><button class="btn btn-red btn-large btn-full">Submit incident report <span>→</span></button>
        </form>
    </div>
</main><?php require 'includes/footer.php'; ?>