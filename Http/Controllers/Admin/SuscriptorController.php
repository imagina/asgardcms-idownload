<?php

namespace Modules\Idownload\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Idownload\Entities\Suscriptor;
use Modules\Idownload\Http\Requests\CreateSuscriptorRequest;
use Modules\Idownload\Http\Requests\UpdateSuscriptorRequest;
use Modules\Idownload\Repositories\SuscriptorRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class SuscriptorController extends AdminBaseController
{
    /**
     * @var SuscriptorRepository
     */
    private $suscriptor;

    public function __construct(SuscriptorRepository $suscriptor)
    {
        parent::__construct();

        $this->suscriptor = $suscriptor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $suscriptors = $this->suscriptor->paginate(20);
        return view('idownload::admin.suscriptors.index', compact('suscriptors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('idownload::admin.suscriptors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSuscriptorRequest $request
     * @return Response
     */
    public function store(CreateSuscriptorRequest $request)
    {
        $this->suscriptor->create($request->all());

        return redirect()->route('admin.idownload.suscriptor.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('idownload::suscriptors.title.suscriptors')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Suscriptor $suscriptor
     * @return Response
     */
    public function edit(Suscriptor $suscriptor)
    {
        return view('idownload::admin.suscriptors.edit', compact('suscriptor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Suscriptor $suscriptor
     * @param  UpdateSuscriptorRequest $request
     * @return Response
     */
    public function update(Suscriptor $suscriptor, UpdateSuscriptorRequest $request)
    {
        $this->suscriptor->update($suscriptor, $request->all());

        return redirect()->route('admin.idownload.suscriptor.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('idownload::suscriptors.title.suscriptors')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Suscriptor $suscriptor
     * @return Response
     */
    public function destroy(Suscriptor $suscriptor)
    {
        $this->suscriptor->destroy($suscriptor);

        return redirect()->route('admin.idownload.suscriptor.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('idownload::suscriptors.title.suscriptors')]));
    }
}
