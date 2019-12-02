<?php

namespace Modules\Idownload\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Idownload\Events\SuscriptorWasCreated;
use Modules\Idownload\Events\Handlers\HandlerSucriptorWasCreated;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    SuscriptorWasCreated::class => [
        HandlerSucriptorWasCreated::class
      ],
  ];
}
