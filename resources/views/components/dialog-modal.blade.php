@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
  <div class="px-6 py-4">
    <div class="text-lg font-medium text-gray-900 dark:text-gray-100">
      {{ $title }}
    </div>

    <div class="mt-4 text-sm text-white dark:text-gray-400">
      {{ $content }}
    </div>
  </div>

  <div class="flex flex-row justify-end bg-gray-100 px-6 py-4 text-end dark:bg-gray-800">
    {{ $footer }}
  </div>
</x-modal>
