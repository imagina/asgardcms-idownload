<?php

namespace Modules\Idownload\Repositories\Eloquent;

use Modules\Idownload\Events\SuscriptorWasCreated;
use Modules\Idownload\Events\SuscriptorWasDeleted;
use Modules\Idownload\Events\SuscriptorWasUpdated;
use Modules\Idownload\Repositories\SuscriptorRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentSuscriptorRepository extends EloquentBaseRepository implements SuscriptorRepository
{

  /**
   * Standard Api Method
   * @param bool $params
   * @return mixed
   */
  public function getItemsBy($params = false)
  {
    /*== initialize query ==*/
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    $includeDefault = [];//Default relationships
    if (isset($params->include)) {//merge relations with default relationships
      $includeDefault = array_merge($includeDefault, $params->include);
      $query->with($includeDefault);//Add Relationships to query
    }

    /*== FILTERS ==*/
    if (isset($params->filter)) {
      $filter = $params->filter;//Short filter

      if (isset($filter->search)) { //si hay que filtrar por rango de precio
        $criterion = $filter->search;
        $param = explode(' ', $criterion);
        $query->where(function ($query) use ($param) {
          foreach ($param as $index => $word) {
            if ($index == 0) {
              $query->where('full_name', 'like', "%" . $word . "%");
              $query->orWhere('email', 'like', "%" . $word . "%");
              $query->orWhere('phone', 'like', "%" . $word . "%");
              $query->orWhere('comment', 'like', "%" . $word . "%");
            } else {
              $query->where('full_name', 'like', "%" . $word . "%");
              $query->orWhere('email', 'like', "%" . $word . "%");
              $query->orWhere('phone', 'like', "%" . $word . "%");
              $query->orWhere('comment', 'like', "%" . $word . "%");
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

  /**
   * Standard Api Method
   * @param $criteria
   * @param bool $params
   * @return mixed
   */
  public function getItem($criteria, $params = false)
  {
    //Initialize query
    $query = $this->model->query();

    /*== RELATIONSHIPS ==*/
    if (in_array('*', $params->include)) {//If Request all relationships
      $query->with(['translations']);
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

      // find translatable attributes
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
   * Standard Api Method
   * Create a iblog post
   * @param  array $data
   * @return Post
   */
  public function create($data)
  {
    $suscriptor = $this->model->create($data);
    event(new SuscriptorWasCreated($suscriptor, $data));

    return $suscriptor;
  }

  /**
   * Update a resource
   * @param $suscriptor
   * @param  array $data
   * @return mixed
   */
  public function update($suscriptor, $data)
  {
    $suscriptor->update($data);

    event(new SuscriptorWasUpdated($suscriptor, $data));


    return $suscriptor;
  }


  public function destroy($model)
  {

    event(new SuscriptorWasDeleted($model->id, get_class($model)));

    return $model->delete();
  }

}
