<?php

namespace Modules\Idownload\Events;

use Modules\Media\Contracts\DeletingMedia;

class SuscriptorWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $suscriptorClass;
    /**
     * @var int
     */
    private $suscriptorId;

    public function __construct($suscriptorId, $suscriptorClass)
    {
        $this->suscriptorClass = $suscriptorClass;
        $this->suscriptorId = $suscriptorId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->suscriptorId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->suscriptorClass;
    }
}
