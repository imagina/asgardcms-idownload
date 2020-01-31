<?php

namespace Modules\Idownload\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Mockery\CountValidator\Exception;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Idownload\Entities\Category;
use Modules\Idownload\Entities\Download;
use Modules\Idownload\Repositories\CategoryRepository;
use Modules\Idownload\Repositories\DownloadRepository;
use Modules\Idownload\Repositories\SuscriptorRepository;
use Route;

class PublicController extends BasePublicController
{
    private $category;
    private $download;
    private $suscriptor;

    public function __construct(DownloadRepository $download, CategoryRepository $category, SuscriptorRepository $suscriptor)
    {
        parent::__construct();
        $this->download = $download;
        $this->category = $category;
        $this->suscriptor = $suscriptor;
    }


    public function index(Request $request){
        $filters = [
          'filter' => [
            'status' => 1
          ],
          'page' => $request->page ?? 1,
          'take' => setting('idocg::docs-per-page'),
          'include' => [],
        ];
        if ($request->category != null){
          $filters['filter']['category'] = $request->category;
        }
        if ($request->q != null){
          $filters['filter']['search'] = $request->q;
        }
        $downloads = $this->download->getItemsBy(json_decode(json_encode($filters)));
        $categories = collect(['title' => trans('idownload::downloads.messages.all'), 'id' => null])->union($this->category->all());
        $tpl = "idownload::frontend.index";
        $ttpl = "idownload.index";
        return view(view()->exists($ttpl) ? $ttpl : $tpl, compact('downloads', 'categories'));
    }


    public function category(Category $category, Request $request)
    {
        $filters = [
          'filter' => [
            'status' => 1
          ],
          'page' => $request->page ?? 1,
          'take' => 12,
          'include' => [],
        ];
        $filters['filter']['categories'] = $category->id;
        if ($request->search != null){
          $filters['filter']['search'] = $request->search;
        }
        $downloads = $this->download->getItemsBy(json_decode(json_encode($filters)));
        $tpl = "idownload::frontend.index";
        $ttpl = "idownload.index";

        if (view()->exists($ttpl)) $tpl = $ttpl;
        return view($tpl, compact('downloads', 'category'));
    }

    public function show(Category $category, Download $download, Request $request)
    {

      $tpl = "idownload::frontend.show";
      $ttpl = "idownload.show";

      $categories = $this->category->all();


      if (view()->exists($ttpl)) $tpl = $ttpl;
      return view($tpl, compact('download', 'category', 'categories'));

    }

    public function sendSubscription(Download $download, Request $request)
    {
      try {
        $data = $request->all();
        $data['download_id'] = $download->id;
        $data['download'] = $download;
        $locale = app()->getLocale();

        $tpl = "idownload::frontend.show";
        $ttpl = "idonwload.show";

        if (setting('iforms::captcha') == "1") {
          $validator = \Validator::make($data, [
            'g-recaptcha-response' => 'required|captcha',
            'full_name' => 'required',
            'email' => 'required|email',
          ]);
          if ($validator->fails()) {
            return redirect()->route(
              $locale . '.idownload.download',
              ['categorySlug' => $download->category->slug, 'downloadSlug' => $download->slug]
            )->withWarning(trans('idownload::idownloads.messages.captcha_required'));
          }
        }
        $this->suscriptor->create($data);
        if (view()->exists($ttpl)) $tpl = $ttpl;
        return redirect()->route(
          $locale . '.idownload.download',
          ['categorySlug' => $download->category->slug, 'downloadSlug' => $download->slug]
        )->withSuccess(trans('idownload::idownloads.messages.subscription_successful'));
      }catch(Exception $e){
        \log::info($e->getMessage());
        return redirect()->back()->withErrors([trans('idownload::idownloads.messages.subscription_send_error',['error'=>$e->getMessage()])]);
      }
    }
}
