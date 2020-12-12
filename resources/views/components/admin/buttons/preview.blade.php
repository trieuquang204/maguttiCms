<x-admin.buttons.button
        type='preview'
        icon="eye"
        :class="$class??'btn-primary'"
        target="_new"
        title="admin.message.view_page"
        href="{{ma_get_admin_preview_url($article)}}"/>
