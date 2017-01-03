<?php


namespace Despark\Cms\Events\Admin;


/**
 * Class AfterSidebarSet.
 */
class AfterSidebarSet
{

    /**
     * @var
     */
    public $sidebar;

    /**
     * AfterSidebarSet constructor.
     * @param $sidebar
     */
    public function __construct($sidebar)
    {
        $this->sidebar = $sidebar;

    }


}