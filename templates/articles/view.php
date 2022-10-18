<!--/** Шаблон вывода статей на отдельной странице */-->
<?php include __DIR__ . '/../header.php'; ?>

<?php if(!empty($error)): ?>
    <div style="background-color: crimson; padding: 5px; margin: 15px">
        <?= $error ?></div>
<?php endif; ?>

    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText()  ?></p>

    <p>Автор статьи:
        <img src="/../media/<?= $article->getAuthor()->getUserPicName()?>.jpg"  alt="avatar" class="avatar">
        <?= $article->getAuthor()->getNickname() ?></p>
    <br><br>

    <?php if(!empty($user)): ?>
        <?php if($user->isAdmin() ||
                $user->getNickname() === $article->getAuthor()->getNickname()): ?>
            <a href="/articles/<?= $article->getId()?>/edit">Редактировать</a>
            <br>
            <a href="/articles/<?= $article->getId()?>/delete">Удалить</a>
            <br><br><br><br>
        <?php endif;?>


    <h3>Комментировать</h3>
    <form action="/articles/<?= $article->getId()?>/comments" method="post">
        <label for="name">Введите свое имя</label><br>
        <input type="text" name="name" id="name"
        value="<?= $_POST['name'] ?? $user->getNickname() ?>" size="50">
        <br><br>
        <label for="text">Напишите свой комментарий</label>
        <textarea name="text" id="text" rows="10" cols="80"><?=$_POST['text'] ?? '' ?></textarea>
        <br><br>
        <input type="submit" value="Отправить">
    </form>

    <?php else: ?>
        Для добавления комментария нужно
        <a href="http://myproject.loc/users/login">авторизоваться</a>
    <?php endif; ?>

    <?php if(!empty($comments)): ?>
        <br><br>
        <h3>Комментарии</h3>
        <?php foreach ($comments as $comment): ?>
            <p><img src="/../media/<?= $comment->getUser()->getUserPicName()?>.jpg"
                    alt="avatar" class="avatar"
                    onerror="this.src='/../media/Текстура бумага (1920x1080).jpg'">
                <?= $comment->getUser()->getNickname() ?></p>
            <p><?= $comment->getText() ?></p>
            <?php if(!empty($user) && ($user->isAdmin() ||
                    $user->getId() === $comment->getUserId())): ?>
                    <a href="/comments/<?= $comment->getId()?>/edit">
                    Редактировать</a>
                    <br>
                    <a href="/comments/<?= $comment->getId()?>/delete">
                        Удалить</a>

            <?php endif; ?>
            <hr><br>
        <?php endforeach; ?>
    <?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>

