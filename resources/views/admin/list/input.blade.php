<input
        id="{!! $item->getConfigProperty('model').'_'.$item->getItemProperty('field').'_'.$item->getId() !!}"
        class="form-control"
        name="{!! $item->getItemProperty('field') !!}[]"
        type="text" value="{{ $item->getValue()  }}"
        data-list-value="{{ $item->getConfigProperty('model').'_'.$item->getId() }}"
        data-list-name="{{ $item->getItemProperty('field') }}"
        autocomplete="off"
/>