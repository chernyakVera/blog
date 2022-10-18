<?php include __DIR__ . '/../header.php'; ?>

<?php if(!empty($error)): ?>
    <h1><?= $error ?></h1>
<?php endif; ?>

<?php if($user->isAdmin()): ?>
    <ul>
        <li><a href="/articles/all">Все статьи</a></li>
        <li><a href="/comments/all">Все комментарии</a></li>
    </ul>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
