<?php

namespace MyProject\Controllers;

use MyProject\Models\Users\UsersAuthService;
use MyProject\View\View;
use MyProject\Models\Articles\Article;

/** Класс для работы с главной страницей */
class MainController extends AbstractController
{
    public function main()
    {
        $this->page(1);
    }


    public function page(int $pageNum)
    {
        $this->view->renderHtml('main/main.php',
        ['articles'=> Article::getPage($pageNum, 3),
            'pagesCount' => Article::getPagesCount(3),
            'currentPageNum' => $pageNum]);
    }
}