<?php
declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepository;

class UpdateArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(string $id, string $title, string $description): void
    {
        $article = $this->articleRepository->getById($id);

        if($article == null)
        {
            //exception
            return;
        }

        $article->update([
            'title'=>$title,
            'description'=>$description
        ]);

        $this->articleRepository->save($article);
    }
}
