<?php

namespace Modules\Idownload\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\User\Transformers\UserProfileTransformer;
use Modules\Media\Image\Imagy;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class SuscriptorTransformer extends BaseApiTransformer
{
  /**
   * @var Imagy
   */
  private $imagy;
  /**
   * @var ThumbnailManager
   */
  private $thumbnailManager;

  public function __construct($resource)
  {
    parent::__construct($resource);

    $this->imagy = app(Imagy::class);
  }

  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'fullName' => $this->when($this->full_name, $this->full_name),
      'email' => $this->when($this->email, $this->email),
      'phone' => $this->when($this->phone, $this->phone),
      'comment' => $this->comment ?? '',
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'download'=> new DownloadTransformer($this->whenLoaded('download'))
    ];

    return $data;
  }
}
