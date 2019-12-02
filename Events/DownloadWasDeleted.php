<?php

namespace Modules\Idownload\Events;

use Modules\Media\Contracts\DeletingMedia;

class DownloadWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private $downloadClass;
    /**
     * @var int
     */
    private $downloadId;

    public function __construct($downloadId, $downloadClass)
    {
        $this->downloadClass = $downloadClass;
        $this->downloadId = $downloadId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId()
    {
        return $this->downloadId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName()
    {
        return $this->downloadClass;
    }
}
