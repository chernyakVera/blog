<?php include __DIR__ . '/../header.php'; ?>

<?php foreach ($articles as $article):?>
    <h1><a href="/articles/<?= $article->getId() ?>"><?= $article->getName(); ?></a></h1>
    <p><?= $article->getShortText(); ?></p>
    <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>
    <br>
    <a href="/articles/<?= $article->getId() ?>/delete">Удалить</a>
    <hr><br>

<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>
