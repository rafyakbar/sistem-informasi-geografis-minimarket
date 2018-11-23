@if($errors->has($name))
    @alert(['type' => 'danger'])
        {{ $errors->first($name) }}
    @endalert
@endif