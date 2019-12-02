<?php

namespace Modules\Idownload\Repositories\Cache;

use Modules\Idownload\Repositories\DownloadRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDownloadDecorator extends BaseCacheDecorator implements DownloadRepository
{
    public function __construct(DownloadRepository $download)
    {
        parent::__construct();
        $this->entityName = 'idownload.downloads';
        $this->repository = $download;
    }
}
