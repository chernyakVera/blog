<!--Шаблон страницы регистрации-->
<?php include __DIR__ . '/../header.php'; ?>

<div style="text-align: center" class="container">
    <h1>Регистрация</h1>
<!--Eсли из контроллера UsersController пришла не пустая ошибка $error,
 то будем ее выводить на красном фоне, а далее будут идти пустые поля
  для заполнения данных пользователем-->
    <?php if (!empty($error)): ?>
        <div style="background-color: crimson; padding: 5px;
                    margin: 15px"><?= $error ?></div>
    <?php endif; ?>


    <form action="/users/register" method="post">
        <table border="0" align="center" class = 'register'>
            <tr >
                <td align="right">Nickname</td>

                    <!--            Конструкция value="--><?// ... ?><!-- позволяет сохранить ранее-->
                    <!--            введенные данные в окошке (+ исп.тернарного оператора сравнения
                                    https://php720.com/lesson/19)-->
                <td align="left">
                    <input type="text" name="nickname" value="<?= $_POST['nickname'] ?? '' ?>">
                </td>
            </tr>
            <tr>
                <td align="right">Email</td>
                <td align="left">
                    <input type="text" name="email" value="<?= $_POST['email'] ?? '' ?>">
                </td>
            </tr>
            <tr>
                <td align="right">Пароль</td>
                <td align="left">
                    <input type="password" name="password" value="<?=$_POST['password'] ?? '' ?>">
                </td>
            </tr>
            <tr>
                <td align="right">Аватар</td>
                <td align="left">
                    <form enctype="multipart/form-data" action="/users/register" method="post">
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000">
                        <input type="file" name="picture" id="picture"/>
                    </form>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <input type="submit" value="Зарегистрироваться">
                </td>
            </tr>
        </table>
    </form>





</div>

<?php include __DIR__ . '/../footer.php'; ?>
