<x-admin.buttons.button
        type='view'
        icon="eye"
        :class="$class??'btn-primary'"
        :title="$title??''"
        href="{{ma_get_admin_view_url($article)}}"/>
