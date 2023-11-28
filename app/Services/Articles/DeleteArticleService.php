<?php
declare(strict_types=1);

namespace App\Services\Articles;

use App\Repositories\ArticleRepository;

class DeleteArticleService
{
    private ArticleRepository $articleRepository;
    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }

    public function execute(string $id):void
    {
        $article = $this->articleRepository->getById($id);
        if ($article == null)
        {
            //throw exception
            return;
        }
        $this->articleRepository->delete($article);
    }
}