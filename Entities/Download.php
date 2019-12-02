<?php

namespace Modules\Idownload\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Core\Traits\NamespacedEntity;
use Laracasts\Presenter\PresentableTrait;


class Download extends Model
{
  use Translatable, MediaRelation, NamespacedEntity, PresentableTrait;

  protected $table = 'idownload__downloads';

  public $translatedAttributes = [
    'title',
    'slug',
    'description',
    'translatable_options',
    'download_id',
  ];

  protected $fillable = [
    'category_id',
    'status',
    'options',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function suscriptors()
  {
    return $this->hasMany(Suscriptor::class);
  }

  /**
   * @return mixed
   */
  public function getDownloadFileAttribute()
  {

    $thumbnail = $this->files()->where('zone', 'downloadFile')->first();
    if (!$thumbnail) {
      return null;
    } else {
      $image = [
        'mimeType' => $thumbnail->mimetype,
        'path' => $thumbnail->path_string,
        'size'=>$thumbnail->filesize
      ];
    }
    return json_decode(json_encode($image));

  }

}
