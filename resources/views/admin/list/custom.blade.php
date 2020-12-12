<ul class="list-unstyled">
    <li>value : {{ $item->getValue()  }}</li>
    <li>field :{{ $item->getItemProperty('field') }}</li>
    <li>model :{{ $item->getConfigProperty('model') }}</li>
    @foreach(App\Example::all() as $user)
        {{$user->title}}
    @endforeach
</ul>