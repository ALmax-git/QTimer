<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-success m-2']) }}>
  {{ $slot }}
</button>
