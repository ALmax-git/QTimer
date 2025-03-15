<button style="border: 1px solid red !important ; color: red;"
  {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 btn  uppercase']) }}>
  {{ $slot }}
</button>
