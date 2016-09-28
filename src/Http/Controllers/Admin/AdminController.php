<?php

namespace Despark\Cms\Http\Controllers\Admin;

use Despark\Cms\Http\Controllers\Controller;
use Despark\Cms\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;
use View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;

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
        $this->viewData['inputs'] = Request::all();

        $this->viewData['pageTitle'] = Str::studly($this->identifier);

        // Fill sidebar
        View::composer('ignicms::admin.layouts.sidebar', function ($view) {
            $view->with('sidebarItems', $this->sidebarItems);
        });
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


}
