<div class="row{{ isset($class) ? $class : '' }}"@isset($d) id="{{ $id }}"@endisset>

    {{ $slot }}

</div>