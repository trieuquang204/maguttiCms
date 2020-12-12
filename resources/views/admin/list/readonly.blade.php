<copyable-input-component
    id="{!! $item->getConfigProperty('model').'_'.$item->getItemProperty('field').'_'.$item->getId() !!}"
    :readonly=true
    name="{!! $item->getItemProperty('field') !!}[]"
    btn_class="btn"
    data_list_value="{{ $item->getConfigProperty('model').'_'.$item->getId() }}"
    data_list_name="{{ $item->getItemProperty('field') }}"
    input_text="{{ $item->getValue()}}">
</copyable-input-component>