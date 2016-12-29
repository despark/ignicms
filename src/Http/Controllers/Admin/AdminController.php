<?php

namespace Despark\Cms\Http\Controllers\Admin;

use View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Despark\Cms\Models\AdminModel;
use Despark\Cms\Http\Controllers\Controller;

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

    /**
     * @var mixed
     */
    public $defaultFormView;

    /**
     * @var
     */
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
            return $dataTable->eloquent($this->prepareModelQuery())
                             ->addColumn('action', function ($record) {
                                 return $this->getActionButtons($record);
                             })->make(true);
        }

        $this->viewData['model'] = $this->model;

        return view('ignicms::admin.layouts.list', $this->viewData);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function prepareModelQuery()
    {
        $tableColumns = $this->model->getAdminTableColumns();
        $query = $this->model->newQuery();
        $table = $this->model->getTable();

        $keyName = $this->model->getKeyName();

        // What if model key is composite
        if (is_array($keyName)) {
            $select = [];
            foreach ($keyName as $key) {
                $select[] = $table.'.'.$key;
            }
            $query->select($select);
        } else {
            $query->select([
                $table.'.'.$this->model->getKeyName(),
            ]);
        }
        $with = [];

        foreach ($tableColumns as $name => $column) {
            // We already included the primary key so check the column and do nothing if exists.
            if (is_array($keyName)) {
                if (in_array($column, $keyName)) {
                    continue;
                }
            } else {
                if ($column == $this->model->getKeyName()) {
                    continue;
                }
            }

            // If it's a relation we need to eager load it.
            if (strstr($column, '.') !== false) {
                $relation = explode('.', $column);
                $relationField = array_pop($relation);
                $with[] = implode('.', $relation);
            } else {
                $query->addSelect($table.'.'.$column);
            }
        }

        if (! empty($with)) {
            $query->with($with);
            // We should refactor this and find actual related field.
            $query->select($table.'.*');
        }

        return $query;
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

    /**
     * @param $record
     * @return string
     */
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
