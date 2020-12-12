<?php namespace App\maguttiCms\Admin;
use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class DashBoardComponent  {

    protected $data;
    protected $request;
    protected $config;

    public function __construct($request)
    {
        $this->request = $request;
        $this->config = config('maguttiCms.admin.list');
        $this->data = collect();
        $this->init();
    }

    public function init()
    {
        $this->data->push([
            'title' => 'Web site',
            'url' => url()->to(''),
            'iconClass' => 'fas fa-globe',
            'target' => "_new",
        ]);
    }


    function getData(){
        foreach ($this->getDashBoardItems() as $_code => $section) {
            $this->data->push([
                'title' => trans('admin.models.' . $_code),
                'url' => ma_get_admin_list_url($section['model']),
                'iconClass' => 'fas fa-' . $section['icon'],
                'target' => null,
            ]);
        }
        return $this->data;
    }

    function getDashBoardItems(){
        return collect($this->config['section'])->where('menu.home')->filter(
            function ($section) {
                return auth_user('admin')->canViewSection($section);
            }
        );
    }
}
