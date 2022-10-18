<?php include __DIR__ . '/../header.php'; ?>

<h1>Редактирование комментария</h1>
<?php if(!empty($error)): ?>
    <div style="background-color: crimson;
    padding: 5px; margin: 15px"><?= $error ?></div>
<?php endif; ?>

<form action="/comments/<?= $comment->getId() ?>/edit" method="post">
    <label for="name">Имя автора комментария</label><br>
    <input type="text" name="name" id="name"
            value="<?=  $comment->getUser()->getNickname()?>"
            size="50" disabled>
    <br><br>
    <label for="text">Текст комментария</label><br>
    <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? $comment->getText() ?></textarea>
    <br><br>
    <input type="submit" value="Обновить">
</form>

<?php include __DIR__ . '/../footer.php'; ?>