<?php

namespace Modules\Idownload\Repositories\Eloquent;

use Modules\Idownload\Events\DownloadWasCreated;
use Modules\Idownload\Events\DownloadWasDeleted;
use Modules\Idownload\Events\DownloadWasUpdated;
use Modules\Idownload\Repositories\DownloadRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentDownloadRepository extends EloquentBaseRepository implements DownloadRepository
{
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      if (isset($filter->category)) {

        $query->where('category_id',$filter->category);
      }

      if (isset($filter->search)) { //si hay que filtrar por rango de precio
        $criterion = $filter->search;
        $param = explode(' ', $criterion);
        $query->where(function ($query) use ($param) {
          foreach ($param as $index => $word) {
            if ($index == 0) {
              $query->whereHas('translations',function($query) use ($word){
                $query->where('title', 'like', "%" . $word . "%");
                $query->orWhere('description', 'like', "%" . $word . "%");
              });
            } else {
              $query->whereHas('translations',function($query) use ($word){
                $query->where('title', 'like', "%" . $word . "%");
                $query->orWhere('description', 'like', "%" . $word . "%");
              });
            }
          }

        });
      }


      //Filter by date
      if (isset($filter->date)) {
        $date = $filter->date;//Short filter date
        $date->field = $date->field ?? 'created_at';
        if (isset($date->from))//From a date
          $query->whereDate($date->field, '>=', $date->from);
        if (isset($date->to))//to a date
          $query->whereDate($date->field, '<=', $date->to);
      }

      //Order by
      if (isset($filter->order)) {
        $orderByField = $filter->order->field ?? 'created_at';//Default field
        $orderWay = $filter->order->way ?? 'desc';//Default way
        $query->orderBy($orderByField, $orderWay);//Add order to query
      }
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    if (isset($params->page) && $params->page) {
      return $query->paginate($params->take);
    } else {
      $params->take ? $query->take($params->take) : false;//Take
      return $query->get();
    }
  }

  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with([]);
    } else {//Especific relationships
      $includeDefault = [];//Default relationships
      if (isset($params->include))//merge relations with default relationships
        $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Filter by specific field
        $field = $filter->field;

      $translatedAttributes = $this->model->translatedAttributes;

      // filter by translatable attributes
      if (isset($field) && in_array($field, $translatedAttributes))//Filter by slug
        $query->whereHas('translations', function ($query) use ($criteria, $filter, $field) {
          $query->where('locale', $filter->locale)
            ->where($field, $criteria);
        });
      else
        // find by specific attribute or by id
        $query->where($field ?? 'id', $criteria);
    }

    /*== FIELDS ==*/
    if (isset($params->fields) && count($params->fields))
      $query->select($params->fields);

    /*== REQUEST ==*/
    return $query->first();
  }

  /**
   * @param $param
   * @return \Illuminate\Database\Eloquent\Collection
   */
  public function search($keys)
  {
    $query = $this->model->query();
    $criterion = $keys;
    $query->whereHas('translations', function (Builder $q) use ($criterion) {
      $q->where('title', 'like', "%{$criterion}%");
    });
    $query->orWhere('id', $criterion);

    return $query->orderBy('created_at', 'desc')->paginate(20);
  }

  /**
   * Standard Api Method
   * Create a iblog post
   * @param  array $data
   * @return Post
   */
  public function create($data)
  {
    $download = $this->model->create($data);
    event(new DownloadWasCreated($download, $data));

    return $download;
  }

  /**
   * Update a resource
   * @param $download
   * @param  array $data
   * @return mixed
   */
  public function update($download, $data)
  {
    $download->update($data);

    event(new DownloadWasUpdated($download, $data));


    return $download;
  }


  public function destroy($model)
  {

    event(new DownloadWasDeleted($model->id, get_class($model)));

    return $model->delete();
  }

  public function whereSlug($slug){
    return $this->model->whereHas('translations',function($query) use($slug){
      $query->where('slug',$slug);
    })->first();
  }

  /**
  * Standard Api Method
  * @param $criteria
  * @param $data
  * @param bool $params
  * @return bool
  */
  public function updateBy($criteria, $data, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      //Update by field
      if (isset($filter->field))
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();

    if ($model) {
      event(new DownloadWasUpdated($model, $data));
      $model->update((array)$data);
    }

  }

  /**
   * Standard Api Method
   * @param $criteria
   * @param bool $params
   */
  public function deleteBy($criteria, $params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== FILTER ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;

      if (isset($filter->field))//Where field
        $field = $filter->field;
    }

    /*== REQUEST ==*/
    $model = $query->where($field ?? 'id', $criteria)->first();
    if ($model) {
      event(new DownloadWasDeleted($model->id, get_class($model)));
      $model->delete();

    }

  }
}
