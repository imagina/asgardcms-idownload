<?php

namespace Modules\Idownload\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Idownload\Http\Requests\CreateSuscriptorRequest;
use Modules\Idownload\Repositories\SuscriptorRepository;
use Modules\Idownload\Transformers\SuscriptorTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Transformers\UserProfileTransformer;
use Route;

//Base API

class SuscriptorApiController extends BaseApiController
{
    /**
     *
     * @var CategoryRepository
     */
    private $download;
    private $suscriptor;

    public function __construct(SuscriptorRepository $suscriptor)
    {
        parent::__construct();
        $this->suscriptor = $suscriptor;
    }

    /**
     * Get Data from Categories
     *
     * @param Request $request
     * @return mixed
     */

    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $suscriptors = $this->suscriptor->getItemsBy($params);

            //Response
            $response = ["data" => SuscriptorTransformer::collection($suscriptors)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($suscriptors)] : false;
        } catch (\Exception $e) {
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
       * GET A ITEM
       *
       * @param $criteria
       * @return mixed
       */
      public function show($criteria,Request $request)
      {
        try {
          //Get Parameters from URL.
          $params = $this->getParamsRequest($request);

          //Request to Repository
          $suscriptor = $this->suscriptor->getItem($criteria, $params);

          //Break if no found item
          if(!$suscriptor) throw new Exception('Item not found',404);

          //Response
          $response = ["data" => new SuscriptorTransformer($suscriptor)];

        } catch (\Exception $e) {
          $status = $this->getStatusError($e->getCode());
          $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
      }


    /**
     * Create a Category
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data
            //Validate Request
            $this->validateRequestApi(new CreateSuscriptorRequest($data));

            //Create item
            $suscriptor = $this->suscriptor->create($data);

            //Response
            $response = ["data" => new SuscriptorTransformer($suscriptor)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Update a Category
     *
     * @param $criteria
     * @param $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateSuscriptorRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->suscriptor->updateBy($criteria, $data, $params);

            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * Delete a Category
     *
     * @param $criteria
     * @param $request
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->suscriptor->deleteBy($criteria, $params);

            //Response
            $response = ["data" => "Item deleted"];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            Log::Error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
