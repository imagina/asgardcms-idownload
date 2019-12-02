<?php

namespace Modules\Idownload\Events;


use Modules\Idownload\Entities\Download;
use Modules\Media\Contracts\StoringMedia;

class DownloadWasUpdated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Post
     */
    public $document;

    public function __construct(Download $document, array $data)
    {
        $this->data = $data;
        $this->document = $document;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->document;
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
