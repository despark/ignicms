<?php

namespace Despark\Http\Controllers\Admin;

use Despark\Http\Controllers\Controller;
use Input;
use View;

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

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->setSidebar();

        $this->viewData['pageTitle'] = 'Admin';
        $this->viewData['inputs'] = Input::all();

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
        $this->sidebarItems = [
            'users' => [
                'name' => 'Team',
                'link' => '#',
                'isActive' => false,
                'iconClass' => 'fa-users',
                'permisionsNeeded' => ['manage_users'],
                'subMenu' => [
                    'users_manager' => [
                        'name' => 'Users Manager',
                        'link' => route('admin.users.index'),
                        'isActive' => false,
                        'permisionsNeeded' => ['manage_users'],
                    ],
                    // 'roles'         => [
                    //     'name'     => 'Roles',
                    //     'link'     => route('admin.roles.index'),
                    //     'isActive' => false,
                    //     'permisionsNeeded' => ['manage_users'],
                    // ],
                    // 'permissions'   => [
                    //     'name'     => 'Permission',
                    //     'link'     => route('admin.permissions.index'),
                    //     'isActive' => false,
                    //     'permisionsNeeded' => ['manage_users'],
                    // ],
                ],
            ],

        ];
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
