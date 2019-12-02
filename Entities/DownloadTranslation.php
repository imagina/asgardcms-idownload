<?php

namespace Modules\Idownload\Entities;

use Illuminate\Database\Eloquent\Model;

class DownloadTranslation extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'title',
    'slug',
    'description',
    'translatable_options',
    'download_id',
  ];

  protected $table = 'idownload__download_translations';

  protected $casts = [
    'translatable_options' => 'array'
  ];
}
