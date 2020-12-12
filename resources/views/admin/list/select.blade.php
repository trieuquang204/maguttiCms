<select id="{!! $item->getConfigProperty('model').'_'.$item->field.'_'.$item->getId() !!}"
        name="{!! $item->field !!}"
        data-list-value="{!! $item->getConfigProperty('model').'_'.$item->getId() !!}"
        data-list-name="{!! $item->field !!}"
        class="btn-select form-control"
>
    @if ($item->getItemProperty('label_empty') )
        <option value="">{{ $item->getItemProperty('label_empty') }}</option>
    @endif
    @foreach($item->relationObj as $option)
        <option
            <?php echo AdminDecorator::selectedHandler($option->{$item->getItemProperty('foreign_key')},$item->getValue()); ?>
            value="{{ $option->{$item->getItemProperty('foreign_key')} }}"
        >
            {{$option->{$item->getItemProperty('label_key')} }}
        </option>
    @endforeach
</select>