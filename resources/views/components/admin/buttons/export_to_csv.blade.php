<x-admin.buttons.button
    type='export_to_csv'
    icon="file-excel"
    :class="$class??'btn-info'"
    :title="$title??'admin.message.export_to_csv'"
    href="{{ma_get_admin_export_url($article)}}"/>
