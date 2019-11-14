<?php

namespace Modules\Idownload\Repositories\Cache;

use Modules\Idownload\Repositories\CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCategoryDecorator extends BaseCacheDecorator implements CategoryRepository
{
    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->entityName = 'idownload.categories';
        $this->repository = $category;
    }
}
