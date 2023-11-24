<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Collections\ArticleCollection;
use App\Models\Article;
use App\RedirectResponse;
use App\Response;
use App\ViewResponse;
use Carbon\Carbon;

class ArticleController extends BaseController
{
    public function index():Response
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollection();

        foreach ($articles as $article){
            $articlesCollection->add(new Article(
                $article['title'],
                $article['description'],
                $article['picture'],
                $article['created_at'],
                (int) $article['id'],
                $article['update_at']

            ));
        }
        return new ViewResponse('articles/index', [
            'articles' => $articlesCollection
        ]);
    }
    public function show(string $id)
    {
        $pictures = [
            "https://media.istockphoto.com/id/1419410080/photo/silent-forest-in-spring-with-beautiful-bright-sun-rays.jpg?s=2048x2048&w=is&k=20&c=7Vegh8lWd5DDLpGh62Hf8NL8HDj3lWUdSIA38xXlLR4=",
            "https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014_1280.jpg",
            "https://cdn.pixabay.com/photo/2012/06/19/10/32/owl-50267_1280.jpg"
        ];
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        $article = new Article(
            $data['title'],
            $data['description'],
            $pictures[array_rand($pictures)],
            $data['created_at'],
            (int) $data['id'],
            $data['update_at']

        );
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
        $_SESSION['flush'] []= ['article_created'];
        $pictures = [
            "https://media.istockphoto.com/id/1419410080/photo/silent-forest-in-spring-with-beautiful-bright-sun-rays.jpg?s=2048x2048&w=is&k=20&c=7Vegh8lWd5DDLpGh62Hf8NL8HDj3lWUdSIA38xXlLR4=",
            "https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014_1280.jpg",
            "https://cdn.pixabay.com/photo/2012/06/19/10/32/owl-50267_1280.jpg"
        ];

        $this->database->createQueryBuilder()
            ->insert('articles')
            ->values(
                [
                    'title' => ':title',
                    'description' => ':description',
                    'picture' => ':picture',
                    'created_at' => ':created_at'
                ]
            )->setParameters([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'picture' => $pictures[array_rand($pictures)],
                'created_at' => Carbon::now()
            ])->executeQuery();

        return new RedirectResponse('/articles');
    }
    public function edit(string $id)
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();
        $article = new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            $data['created_at'],
            (int) $data['id'],
            $data['update_at']
        );
        return new ViewResponse('articles/edit', [
            'article' => $article
        ]);
    }
    public function update(string $id)
    {
        $this->database->createQueryBuilder()
            ->update('articles')
            ->set('title', ':title')
            ->set('description', ':description')
            ->where('id ='. ':id')
            ->setParameters([
                'id' => $id,
                'title' => $_POST['title'],
                'description' => $_POST['description'],
            ])->executeQuery();
        return new RedirectResponse('/articles');
    }
    public function delete(string $id)
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', $_POST['id'])
        ->executeQuery();
        return new RedirectResponse('/articles');
    }

}