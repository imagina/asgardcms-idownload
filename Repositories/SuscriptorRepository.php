<?php

namespace Modules\Idownload\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SuscriptorRepository extends BaseRepository
{
  public function create($data);
  public function update($download, $data);
  public function destroy($model);
}
