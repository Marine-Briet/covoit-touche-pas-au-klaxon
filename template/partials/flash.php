<?php

use Core\Flash;

$success = Flash::get('success');
$error = Flash::get('error');
$delete = Flash::get('delete');
?>

<?php if ($success): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($delete): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($delete) ?>
    </div>
<?php endif; ?>