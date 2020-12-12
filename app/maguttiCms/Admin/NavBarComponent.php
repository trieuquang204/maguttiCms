<?php namespace App\maguttiCms\Admin;
use Form;
use App;

/**
 * Class AdminTree
 * @package App\maguttiCms\Admin
 */
class NavBarComponent  {

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
        
    }


    function getData(){
        foreach ($this->getNavBarItems() as $_code => $section) {
            $this->data->push([
                    'title' => trans('admin.models.' . $_code),
                    'url' => ma_get_admin_list_url($section['model']),
                    'iconClass' => 'fas fa-' . $section['icon'],
                    'target' => null,
                    'section' => $_code,
                    'submenu' => $this->getNavBarSubItems($section,$_code)
                ]
            );
        }
        return $this->data;
    }

    function getNavBarItems(){
        return collect($this->config['section'])->where('menu.top-bar.show')->filter(
            function ($section) {
                return auth_user('admin')->canViewSection($section);
            }
        );
    }

    function getNavBarSubItems($section,$parent){
        $data = collect();

        if(isset($section['menu']['top-bar']['submodel'])){
            foreach ($section['menu']['top-bar']['submodel'] as $_code => $item ){
                $data->push([
                    'title' => trans('admin.models.' . $_code),
                    'url' => ma_get_admin_list_url($_code),
                    'iconClass' => 'fas fa-' . $item['icon'],
                    'target' => null,
                    'section' => $_code,
                ]);
            }
        }
        return $data;
    }
}
