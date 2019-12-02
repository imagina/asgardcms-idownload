<?php

namespace Modules\Idownload\Transformers;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Tag\Transformers\TagTransformer;
use Modules\User\Transformers\UserProfileTransformer;
use Illuminate\Support\Arr;
use Modules\Ihelpers\Transformers\BaseApiTransformer;

class DownloadTransformer extends BaseApiTransformer
{
  public function toArray($request)
  {
    $data = [
      'id' => $this->when($this->id, $this->id),
      'title' => $this->when($this->title, $this->title),
      'slug' => $this->when($this->slug, $this->slug),
      'description' => $this->when($this->description, $this->description),
      'status' => $this->when($this->status, intval($this->status)),
      'downloadFile' => $this->download_file,
      'createdAt' => $this->when($this->created_at, $this->created_at),
      'updatedAt' => $this->when($this->updated_at, $this->updated_at),
      'category' => new CategoryTransformer($this->category),
      'categoryId' => $this->when($this->category_id, $this->category_id),
    ];
    $filter = json_decode($request->filter);

    // Return data with available translations
    if (isset($filter->allTranslations) && $filter->allTranslations) {
      // Get langs avaliables
      $languages = \LaravelLocalization::getSupportedLocales();

      foreach ($languages as $lang => $value) {
        $data[$lang]['title'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['title'] : '';
        $data[$lang]['slug'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['slug'] : '';
        $data[$lang]['description'] = $this->hasTranslation($lang) ?
          $this->translate("$lang")['description'] ?? '' : '';
      }
    }

    return $data;

  }
}
