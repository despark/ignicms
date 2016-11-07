<?php

namespace Despark\Cms\Http\Controllers\Admin;

use Despark\Cms\Http\Controllers\Controller;
use Despark\Cms\Models\AdminModel;
use View;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

/**
 * Class AdminController.
 */
class AdminController extends Controller
{
    /**
     * used for sending data to array.
     *
     * @array
     */
    public $viewData = [];

    /**
     * sidebar menu.
     *
     * @array
     */
    public $sidebarItems = [];

    /**
     * @var int
     */
    public $paginateLimit;

    public $defaultFormView;

    protected $identifier;

    /**
     * @var AdminModel
     */
    protected $model;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->setSidebar();

        $this->paginateLimit = config('admin.bootstrap.paginateLimit');
        $this->defaultFormView = config('admin.bootstrap.defaultFormView');

        $this->viewData['pageTitle'] = 'Admin';
        $this->viewData['inputs'] = \Request::all();

        $this->viewData['pageTitle'] = Str::studly($this->identifier);

        // Fill sidebar
        View::composer('ignicms::admin.layouts.sidebar', function ($view) {
            $view->with('sidebarItems', $this->sidebarItems);
        });
    }

    /**
     * @param Request $request
     * @param Datatables $dataTable
     * @return \Illuminate\Http\JsonResponse|View
     */
    public function index(Request $request, Datatables $dataTable)
    {
        if ($request->ajax()) {
            $records = $this->model->select(['id',] + $this->model->getAdminTableColumns());

            return $dataTable->eloquent($records)
                             ->addColumn('action', function ($record) {
                                 return $this->getActionButtons($record);
                             })->make(true);
        }

        $this->viewData['model'] = $this->model;

        return view('ignicms::admin.layouts.list', $this->viewData);
    }

    /**
     * set sidebarMenu.
     */
    public function setSidebar()
    {
        $this->sidebarItems = config('admin.sidebar');
    }

    /**
     * Admin dashboard.
     *
     * @return mixed
     */
    public function adminHome()
    {
        return view('ignicms::admin.pages.home');
    }

    /**
     * Admin dashboard.
     *
     * @return mixed
     */
    public function forbidden()
    {
        $this->notify([
            'type' => 'warning',
            'title' => 'No access!',
            'description' => 'Sorry, you don\'t have access to manage this resources',
        ]);

        return redirect(route('adminHome'));
    }

    /**
     * set notification.
     *
     *
     * @param array $notificationInfo
     */
    public function notify(array $notificationInfo)
    {
        session()->flash('notification', $notificationInfo);
    }

    protected function getActionButtons($record)
    {
        $editBtn = '';
        $deleteBtn = '';
        if (isset($this->viewData['editRoute'])) {
            $editBtn = '<a href="'.route($this->viewData['editRoute'],
                    ['id' => $record->id]).'" class="btn btn-primary">'.trans('admin.edit').'</a>';
        }

        if (isset($this->viewData['deleteRoute'])) {
            $deleteBtn = '<a href="#"  class="js-open-delete-modal btn btn-danger"
                    data-delete-url="'.route($this->viewData['deleteRoute'], ['id' => $record->id]).'">
                    '.trans('admin.delete').'
                </a>';
        }

        $container = "<div class='action-btns'>{$editBtn}{$deleteBtn}</div>";

        return $container;
    }
}
