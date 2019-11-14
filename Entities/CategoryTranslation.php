<?php

namespace Modules\Idownload\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
  public $timestamps = false;

  protected $fillable = [
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'translatable_options',
    'category_id',
  ];

  protected $table = 'idownload__category_translations';

  protected $casts = [
    'translatable_options' => 'array'
  ];

  /**
   * Return the sluggable configuration array for this model.
   *
   * @return array
   */
  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'title'
      ]
    ];
  }

  public function getMetaDescriptionAttribute()
  {
    return $this->meta_description ?? substr(strip_tags($this->description ?? ''), 0, 150);
  }

  public function getTranslatableOptionAttribute($value)
  {
    return json_decode($value);
  }

  /**
   * @return mixed
   */
  public function getMetaTitleAttribute()
  {
    return $this->meta_title ?? $this->title;
  }
}
