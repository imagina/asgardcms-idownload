<?php

namespace Modules\Idownload\Events;

use Modules\Idownload\Entities\Download;
use Modules\Media\Contracts\StoringMedia;

class DownloadWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Download
     */
    public $download;

    public function __construct($download, array $data)
    {
        $this->data = $data;
        $this->download = $download;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->download;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
}
