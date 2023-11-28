<?php
declare(strict_types=1);

namespace App\Controllers;

use App\RedirectResponse;
use App\Response;
use App\Services\Articles\DeleteArticleService;
use App\Services\Articles\IndexArticleService;
use App\Services\Articles\ShowArticleService;
use App\Services\Articles\StoreArticleService;
use App\Services\Articles\UpdateArticleService;
use App\ViewResponse;

class ArticleController
{
    public function index():Response
    {
       $service = new IndexArticleService();
       $articles = $service->execute();

        return new ViewResponse('articles/index', [
            'articles' => $articles
        ]);
    }
    public function show(string $id)
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/show', [
            'article' => $article
        ]);
    }
    public function create():Response
    {
        return new ViewResponse('articles/create');
    }
    public function store()
    {
        $service = new StoreArticleService();
        $service->execute($_POST['title'], $_POST['description']);

        return new RedirectResponse('/articles');
    }
    public function edit(string $id)
    {
        $service = new ShowArticleService();
        $article = $service->execute($id);

        return new ViewResponse('articles/edit', [
            'article' => $article
        ]);
    }
    public function update(string $id)
    {
        $service = new UpdateArticleService();
        $service->execute($id, $_POST['title'], $_POST['description']);

        return new RedirectResponse('/articles');
    }
    public function delete(string $id)
    {
       $service = new DeleteArticleService();
       $service->execute($id);

        return new RedirectResponse('/articles');
    }
}