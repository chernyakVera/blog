<!--Шаблон с полями-формами для авторизации пользователя-->
<?php include __DIR__ . '/../header.php'?>

<div style="text-align: center;">
    <h1>Вход</h1>

    <?php if(!empty($error)): ?>
        <div style="background-color: crimson;
                    padding: 5px; margin: 15px;"><?=$error ?></div>
    <?php endif; ?>

    <form action="/users/login" method="post">
        <table align="center" class = 'register'>
            <tr>
                <td>Email</td>
                <td>
                    <input type="text" name="email"
                           value="<?= $_POST['email'] ?? '' ?>">
                </td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td>
                    <input type="password" name="password"
                           value="<?= $_POST['password'] ?? '' ?>">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="Войти">
                </td>
            </tr>

        </table>
    </form>
</div>
<?php include __DIR__ . '/../footer.php'?>