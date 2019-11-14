<?php

namespace Modules\Idownload\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface DownloadRepository extends BaseRepository
{
  /**
   * @param $params
   * @return mixed
   */
  public function getItemsBy($params);

  /**
   * @param $criteria
   * @param $params
   * @return mixed
   */
  public function getItem($criteria, $params);
}
