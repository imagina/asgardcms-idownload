<?php

namespace Modules\Idownload\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  use Translatable;

  protected $table = 'idownload__categories';

  public $translatedAttributes = [
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'meta_keywords',
  ];

  protected $fillable = [
    'title',
    'description',
    'slug',
    'parent_id',
    'options',
  ];

  public function parent()
  {
    return $this->belongsTo(Category::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Category::class, 'parent_id');
  }

  public function downloads()
  {
    return $this->hasMany(Download::class);
  }

}
