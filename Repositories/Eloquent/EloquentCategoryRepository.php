<?php

namespace Modules\Idownload\Repositories\Eloquent;

use Modules\Idownload\Repositories\CategoryRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{

  public function create($data)
  {
    $category= $this->model->create($data);
    return $this->find($category->id);
  }

  public function whereSlug($slug){
    return $this->model->whereHas('translations',function($query) use($slug){
      $query->where('slug',$slug);
    })->first();
  }

}
