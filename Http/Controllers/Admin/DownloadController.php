<?php

namespace Modules\Idownload\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Idownload\Entities\Download;
use Modules\Idownload\Http\Requests\CreateDownloadRequest;
use Modules\Idownload\Http\Requests\UpdateDownloadRequest;
use Modules\Idownload\Repositories\DownloadRepository;
use Modules\Idownload\Repositories\CategoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class DownloadController extends AdminBaseController
{
    /**
     * @var DownloadRepository
     */
    private $download;
    private $category;

    public function __construct(DownloadRepository $download, CategoryRepository $category)
    {
        parent::__construct();

        $this->download = $download;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
      if($request->input('q')){
        $param=$request->input('q');
        $downloads = $this->download->search($param);
      }else {
        $downloads = $this->download->paginate(20);
      }

        return view('idownload::admin.downloads.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $categories=$this->category->all();
        return view('idownload::admin.downloads.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDownloadRequest $request
     * @return Response
     */
    public function store(CreateDownloadRequest $request)
    {
        $this->download->create($request->all());

        return redirect()->route('admin.idownload.download.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('idownload::downloads.title.downloads')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Download $download
     * @return Response
     */
    public function edit(Download $download)
    {
        $categories = $this->category->all();
        return view('idownload::admin.downloads.edit', compact('download', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Download $download
     * @param  UpdateDownloadRequest $request
     * @return Response
     */
    public function update(Download $download, UpdateDownloadRequest $request)
    {
        $this->download->update($download, $request->all());

        return redirect()->route('admin.idownload.download.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('idownload::downloads.title.downloads')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Download $download
     * @return Response
     */
    public function destroy(Download $download)
    {
        $this->download->destroy($download);

        return redirect()->route('admin.idownload.download.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('idownload::downloads.title.downloads')]));
    }
}
