<?php
    if (!isset($class))
        $class = '';

    if (isset($size)) {
        if (is_int($size)) {
            $class .= 'col-lg-' . $size;
        }
        else if (is_array($size)) {
            $media = ['lg', 'md', 'sm', 'xs'];

            foreach ($size as $index => $value) {
                $class .= 'col-' . $media[$index] . '-' . $size . ' ';
            }
        }
    }
    else {
        if (empty($class))
            $class .= 'col';
    }
?>

<div class="{{ $class }}"@isset($d) id="{{ $id }}"@endisset>

    {{ $slot }}

</div>