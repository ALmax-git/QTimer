@props(['disabled' => false])

<input style="background-color: rgba(0, 0, 0, 0); color: #28f100 !important; border: 2px solid rgb(60, 255, 0);"
  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
