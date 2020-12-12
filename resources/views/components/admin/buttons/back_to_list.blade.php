<x-admin.buttons.button
    type='back_to_list'
    icon="reply"
    :class="$class??'btn-info'"
    :title="$title??'admin.message.back_to_list'"
    href="{{ma_get_admin_list_url($article)}}"/>
