<?php

namespace Modules\Idownload\Entities;

use Illuminate\Database\Eloquent\Model;

class Suscriptor extends Model
{
  protected $table = 'idownload__suscriptors';

  protected $fillable = [
    'full_name',
    'email',
    'phone',
    'comment',
    'slug',
    'options',
    'download_id',
  ];

  public function download()
  {
    return $this->belongsTo(Download::class);
  }
}
