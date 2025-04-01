<div class="container-fluid px-4 pt-4" style="min-height: 80vh;">
  <div class="h-100 bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="mb-0">To Do List</h6>
      <a href="#">Show All</a>
    </div>

    <!-- Search and Per Page Selection -->
    <div class="d-flex mb-2">
      <input class="form-control me-2 bg-transparent" type="text" wire:model.debounce.500ms="search"
        placeholder="Search tasks...">
      <select class="form-control w-auto bg-transparent" wire:model="perPage">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="15">15</option>
      </select>
    </div>

    <!-- Add Task -->
    <div class="d-flex mb-2">
      <input class="form-control bg-transparent" type="text" wire:model="task" placeholder="Enter task">
      <button class="btn btn-primary ms-2" wire:click="addTask">Add</button>
    </div>

    <!-- Table Headers with Sorting -->
    <div class="d-flex justify-content-between fw-bold bg-dark rounded p-2 text-white">
      <span class="cursor-pointer" wire:click="setSort('title')">Title</span>
      <span class="cursor-pointer" wire:click="setSort('priority')">Priority</span>
      <span class="cursor-pointer" wire:click="setSort('status')">Status</span>
      <span class="cursor-pointer" wire:click="setSort('due_date')">Due Date</span>
      <span>Action</span>
    </div>

    @foreach ($todos as $task)
      <div class="d-flex align-items-center border-bottom py-2">
        <input class="form-check-input m-0" type="checkbox" wire:click="toggleStatus({{ $task->id }})"
          {{ $task->status === 'completed' ? 'checked' : '' }}>
        <div class="w-100 ms-3">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <span class="{{ $task->status === 'completed' ? 'text-decoration-line-through' : '' }}">
              {{ $task->title }} - <small class="text-muted">{{ ucfirst($task->priority) }}</small>
            </span>
            <button class="btn btn-sm text-danger" wire:click="deleteTask({{ $task->id }})">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
      </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-3">
      {{ $todos->links() }}
    </div>
  </div>
</div>
