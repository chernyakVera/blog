</td>

<td width="300px" class="sidebar">
    <div class="sidebarHeader">Меню</div>
    <ul>
        <li><a href="/">Главная страница</a></li>
        <li><a href="/users/register">Регистрация</a></li>
        <li><a href="/articles/add">Добавить статью</a></li>

        <?php if(isset($user) && $user->isAdmin()): ?>
        <li><a href="/admin/cabinet">Кабинет адинистратора</a></li>
        <?php endif;?>

        <?php if(!empty($user)):?>
        <li><a href="/users/<?=$user->getId() ?>/cabinet">Кабинет пользователя</a></li>
        <?php endif;?>
    </ul>
</td>
</tr>
<tr>
    <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
</tr>
</table>

</body>
</html>