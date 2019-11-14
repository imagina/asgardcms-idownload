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
   * Create a iblog post
   * @param  array $data
   * @return Post
   */
  public function create($data)
  {
    $download = $this->model->create($data);
    event(new SuscriptorWasCreated($download, $data));

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

    event(new SuscriptorWasUpdated($download, $data));


    return $download;
  }


  public function destroy($model)
  {

    event(new SuscriptorWasDeleted($model->id, get_class($model)));

    return $model->delete();
  }

}
