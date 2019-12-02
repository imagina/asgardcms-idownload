<?php

namespace Modules\Idownload\Repositories\Cache;

use Modules\Idownload\Repositories\SuscriptorRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheSuscriptorDecorator extends BaseCacheDecorator implements SuscriptorRepository
{
    public function __construct(SuscriptorRepository $suscriptor)
    {
        parent::__construct();
        $this->entityName = 'idownload.suscriptors';
        $this->repository = $suscriptor;
    }
}
