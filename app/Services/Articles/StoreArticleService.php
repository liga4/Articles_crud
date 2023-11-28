<?php
namespace App\Services\Articles;

use App\Models\Article;
use App\Repositories\ArticleRepository;

class StoreArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

  public function execute(string $title, string $description):void
  {
      $pictures = [
          "https://media.istockphoto.com/id/1419410080/photo/silent-forest-in-spring-with-beautiful-bright-sun-rays.jpg?s=2048x2048&w=is&k=20&c=7Vegh8lWd5DDLpGh62Hf8NL8HDj3lWUdSIA38xXlLR4=",
          "https://cdn.pixabay.com/photo/2014/02/27/16/10/flowers-276014_1280.jpg",
          "https://cdn.pixabay.com/photo/2012/06/19/10/32/owl-50267_1280.jpg"
      ];
      $article = new Article(
          $title,
          $description,
          $pictures[array_rand($pictures)]
      );
      $this->articleRepository->save($article);
  }
}