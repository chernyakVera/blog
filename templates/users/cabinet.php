<?php include __DIR__ . '/../header.php'; ?>

<?php if(!empty($error)): ?>
    <h1><?= $error ?></h1>
<?php endif; ?>

<?php if(!empty($user)): ?>
    <ul>
        <li><strong>Имя пользователя: </strong><?= $user->getNickname() ?></li><br>
        <li><strong>Email пользователя: </strong><?= $user->getEmail() ?></li><br>
        <?php if(!empty($user->getUserPicName())):?>
            <li><strong>Сменить аватар: </strong>
                <img src="/../media/<?= $user->getUserPicName()?>.jpg"  alt="avatar" class="avatar">
            </li><br>
        <?php else:?>
            <li><strong>Добавить аватар: </strong></li><br>
        <?php endif;?>
            <form enctype="multipart/form-data" action="/users/<?= $user->getId() ?>/cabinet" method="post">
                <label>Аватар
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input type="file" name="picture" id="picture"/>
                </label>
                <br><br>
                <input type="submit" value="Отправить файл">
            </form>
        <?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>
