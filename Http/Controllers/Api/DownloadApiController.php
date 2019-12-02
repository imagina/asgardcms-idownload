<?php

namespace Modules\Idownload\Http\Controllers\Api;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Idownload\Http\Requests\CreateDownloadRequest;
use Modules\Idownload\Http\Requests\CreateSuscriptorRequest;
use Modules\Idownload\Repositories\DownloadRepository;
use Modules\Idownload\Repositories\SuscriptorRepository;
use Modules\Idownload\Transformers\DownloadTransformer;
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Modules\User\Transformers\UserProfileTransformer;
use Route;

class DownloadApiController extends BaseApiController
{
    /**
     * @var PostRepository
     */
    private $download;
    private $suscriptor;


    public function __construct(DownloadRepository $download, SuscriptorRepository $suscriptor)
    {
        parent::__construct();
        $this->download = $download;
        $this->suscriptor = $suscriptor;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $downloads = $this->download->getItemsBy($params);

            //Response
            $response = ["data" => DownloadTransformer::collection($downloads)];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($downloads)] : false;
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
        $download = $this->download->getItem($criteria, $params);

        //Break if no found item
        if(!$download) throw new Exception('Item not found',404);

        //Response
        $response = ["data" => new DownloadTransformer($download)];

      } catch (\Exception $e) {
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
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
            $this->validateRequestApi(new CreateDownloadRequest($data));

            //Create item
            $download = $this->download->create($data);

            //Response
            $response = ["data" => new DownloadTransformer($download)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateDownloadRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->download->updateBy($criteria, $data, $params);

            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->download->deleteBy($criteria, $params);

            //Response
            $response = ["data" => "Item deleted"];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            Log::Error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    function sendSubscription($criteria,Request $request){
      \DB::beginTransaction(); //DB Transaction
      try {
        //Get data
        $data = $request->input('attributes') ?? [];//Get data

        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $download = $this->download->getItem($criteria,$params);

        $data['download_id'] = $criteria;

        $data['download'] = $download;

        $validator = \Validator::make($data,[
          'captcha' => 'required|captcha',
          'full_name' => 'required',
          'email' => 'required|email',
        ]);

        if ($validator->fails()) {
          return response()->json(["data" => $validator->errors()],500);
        }

        $suscriptor = $this->suscriptor->create($data);

        //Response
        $response = ["data" => 'Email Subscribed'];
        \DB::commit();//Commit to DataBase
      } catch (\Exception $e) {
        Log::Error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
