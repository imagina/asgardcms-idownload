<?php

namespace Modules\Idownload\Events;

use Modules\Idownload\Entities\Suscriptor;
use Modules\Media\Contracts\StoringMedia;

class SuscriptorWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public $data;
    /**
     * @var Suscriptor
     */
    public $suscriptor;

    public function __construct($suscriptor, array $data)
    {
        $this->data = $data;
        $this->suscriptor = $suscriptor;
    }

    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->suscriptor;
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
