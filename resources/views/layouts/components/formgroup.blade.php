<div class="form-group {{ isset($row) && $row ? 'row' : '' }} {{ isset($class) ? $class : '' }}">
    {{ $slot }}
</div>

@isset($name)
    @error(['name' => $name])
    @enderror
@endisset