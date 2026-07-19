<?php

use Core\Flash;

$success = Flash::get('success');
$error = Flash::get('error');
?>

<?php if ($success): ?>
    <div class="alert alert-secondary">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>