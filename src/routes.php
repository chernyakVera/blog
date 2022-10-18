<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [MyProject\Controllers\ArticlesController::class, 'deleteArticle'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'comment'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^admin/cabinet$~' => [\MyProject\Controllers\AdminController::class, 'cabinet'],
    '~^articles/all$~' => [\MyProject\Controllers\ArticlesController::class, 'getAllArticles'],
    '~^comments/all$~' => [\MyProject\Controllers\CommentsController::class, 'getAllComments'],
    '~^(\d+)$~' => [\MyProject\Controllers\MainController::class, 'page'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'deleteComment'],
    '~^users/avatar$~' => [\MyProject\Controllers\UsersController::class, 'addAvatar'],
    '~^users/(\d+)/cabinet$~' => [\MyProject\Controllers\UsersController::class, 'cabinet'],
];