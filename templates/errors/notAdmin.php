<?php include __DIR__ . '/../header.php'; ?>

<?php if(!$user->isAdmin() && (!empty($error))): ?>
    <h1><?= $error ?></h1>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
