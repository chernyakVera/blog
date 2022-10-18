<?php include __DIR__ . '/../header.php'; ?>

<?php if(isset($comments)): ?>
    <?php foreach ($comments as $comment):?>

        <h3>Комментарий к статье: <a href="/articles/<?= $comment->getArticleId()?>">
                <?= $comment->getArticleName($comment->getArticleId()) ?></a></h3>
                <h3><?= $comment->getUser()->getNickname(); ?></h3>
                <p><?= $comment->getText(); ?></p>
                <a href="/comments/<?= $comment->getId() ?>/edit">Редактировать</a>
                <br>
                <a href="/comments/<?= $comment->getId() ?>/delete">Удалить</a>
                <hr><br>

    <?php endforeach; ?>
<?php endif;?>

<?php include __DIR__ . '/../footer.php'; ?>