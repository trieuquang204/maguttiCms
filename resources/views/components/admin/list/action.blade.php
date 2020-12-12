@foreach($pageConfig['actions'] as $key => $action )
  @if(AdminList::isAction($key) && auth_user('admin')->action($key,$pageConfig))
    <x-dynamic-component :component="'admin.buttons.'.$key" :article="$article"/>
  @endif
@endforeach


