<x-admin.buttons.button
    type='impersonated'
    icon="users"
    :class="$class ??'btn-warning'"
    href="{{ma_get_admin_impersonated_url($article)}}"
    target="new"/>
