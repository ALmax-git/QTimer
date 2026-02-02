@props(['disabled' => false])

<input style="background-color: rgba(0, 0, 0, 0); color: #0000ff !important; border: 2px solid rgb(13, 0, 255);"
  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
