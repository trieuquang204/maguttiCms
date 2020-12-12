<x-admin.buttons.button
    type='delete'
    icon="trash"
    :class="$class??'btn-danger'"
    href="{{ma_get_admin_delete_url($article)}}"/>
