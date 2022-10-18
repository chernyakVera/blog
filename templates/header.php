<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой блог</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header"><?=$title ?? 'Мой блог' ?></td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">

            <?php if(!empty($user)):?>
            <img src="/../media/<?= $user->getUserPicName()?>.jpg"
                 alt="avatar" class="avatar"
                 onerror="this.src='/../media/Текстура бумага (1920x1080).jpg'">
                Привет, <?= $user->getNickname() ?> | <a href="http://myproject.loc/users/logout">Выйти</a>
            <?php else:?>
                <a href="http://myproject.loc/users/login">Войдите на сайт</a> | <a href="http://myproject.loc/users/register">Зарегистрироваться</a>
            <?php endif;?>

        </td>
    </tr>
    <tr>
        <td>