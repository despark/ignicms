<?php

namespace App\Http\Controllers\Admin;

use Despark\Cms\Models\SeoPage;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SeoPagesRequest;
use Despark\Cms\Http\Controllers\Admin\AdminController;

class SeoPagesController extends AdminController
{
    public function __construct(SeoPage $model)
    {
        $this->identifier = 'seo_page';
        $this->model = $model;

        parent::__construct();

        $this->sidebarItems['seo_page']['isActive'] = true;
        $this->viewData['createRoute'] = 'seo_page.create';
        $this->viewData['editRoute'] = 'seo_page.edit';
        $this->viewData['deleteRoute'] = 'seo_page.destroy';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->viewData['record'] = $this->model;

        $this->viewData['actionVerb'] = 'Create';
        $this->viewData['formMethod'] = 'POST';
        $this->viewData['formAction'] = 'seo_page.store';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(SeoPagesRequest $request)
    {
        $input = $request->all();

        $record = $this->model->create($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful create!',
            'description' => 'SeoPage is created successfully!',
        ]);

        return redirect(route('seo_page.edit', ['id' => $record->id]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $record = $this->model->findOrFail($id);

        $this->viewData['record'] = $record;

        $this->viewData['formMethod'] = 'PUT';
        $this->viewData['formAction'] = 'seo_page.update';

        return view($this->defaultFormView, $this->viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Response
     */
    public function update(SeoPagesRequest $request, $id)
    {
        $input = $request->all();

        $record = $this->model->findOrFail($id);

        $record->update($input);

        $this->notify([
            'type' => 'success',
            'title' => 'Successful update!',
            'description' => 'SeoPage is updated successfully.',
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->model->findOrFail($id)->delete();

        $this->notify([
            'type' => 'danger',
            'title' => 'Successful delete!',
            'description' => 'SeoPage is deleted successfully.',
        ]);

        return redirect()->back();
    }
}
