<?php

namespace Despark\Http\Controllers\Admin;

use Despark\Http\Controllers\Controller;
use Input;
use View;
use Illuminate\Support\Str;

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
    public $sidebarItems = array();

    /**
     * @var int
     */
    public $paginateLimit = 15;

    public $defaultFormView = 'admin.formElements.defaultForm';

    protected $identifier;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->setSidebar();

        $this->viewData['pageTitle'] = 'Admin';
        $this->viewData['inputs'] = Input::all();

        $this->viewData['pageTitle'] = Str::title($this->identifier);

        // Fill sidebar
        View::composer('admin.layouts.sidebar', function ($view) {
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
        return view('admin.pages.home');
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
