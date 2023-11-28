<?php
declare(strict_types=1);

namespace App\Services\Articles;

use App\Models\Article;
use App\Repositories\ArticleRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class ShowArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct()
    {
        $this->articleRepository = new ArticleRepository();
    }
    public function execute(string $id):Article
    {
        return $this->articleRepository->getById($id);
    }
}