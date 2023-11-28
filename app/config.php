<?php

namespace app;

use App\Repositories\ArticleRepository;
use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    'ArticleRepository' => function () {
        return new ArticleRepository();
    }
]);

return $containerBuilder->build();