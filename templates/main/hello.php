<?php include __DIR__ . '/../header.php' ?>
Привет, <?= $name ?>!!!
<!--/** получаю переменную $name из класса View метод renderHtml,
        который получает данные из класса MainController метода sayHello(),
        использование именно этого контроллера и метода было определено в routes.php и index.php -->
<?php include __DIR__ . '/../footer.php'?>
