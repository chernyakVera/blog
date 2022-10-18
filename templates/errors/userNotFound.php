<?php include __DIR__ . '/../header.php'; ?>

<div style="text-align: center">
    <h1>Произошла ошибка при активации пользователя.</h1>
    <?php if (!empty($error)):?>
        <div style="background-color: crimson; padding: 5px;
              margin: 15px"><?= $error ?></div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>

