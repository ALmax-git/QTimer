<div class="container-fluid px-4 pt-4" style="min-height: 80vh;">
  <div class="h-100 bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="mb-0">To Do List</h6>
      <a href="#">Show All</a>
    </div>

    <div class="d-flex mb-2">
      <input class="form-control me-2 bg-transparent" type="text" wire:model="search" placeholder="Search task">
      <select class="form-select me-2 bg-transparent" wire:model="priority">
        <option value="">All Priorities</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>
    </div>

    <div class="mb-3">
      <input class="form-control bg-transparent" type="text" wire:model="task" placeholder="Task title">
      <textarea class="form-control mt-2 bg-transparent" wire:model="description" placeholder="Task description"></textarea>
      <input class="form-control mt-2 bg-transparent" type="date" wire:model="due_date">
      <select class="form-select mt-2 bg-transparent" wire:model="priority">
        <option value="low">Low</option>
        <option value="medium" selected>Medium</option>
        <option value="high">High</option>
      </select>
      <button class="btn btn-primary mt-2" wire:click="{{ $editId ? 'updateTask' : 'addTask' }}">
        {{ $editId ? 'Update Task' : 'Add Task' }}
      </button>
    </div>

    @foreach ($tasks as $task)
      <div class="d-flex align-items-center border-bottom py-2">
        <div class="w-100 ms-3">
          <div class="d-flex w-100 align-items-center justify-content-between">
            <span class="{{ $task->status === 'completed' ? 'text-decoration-line-through' : '' }}">
              {{ $task->title }} - <small class="text-info">{{ ucfirst($task->priority) }}</small>
            </span>
            <button class="btn btn-sm text-primary" wire:click="editTask({{ $task->id }})"><i
                class="fa fa-edit"></i></button>
            <button class="btn btn-sm text-danger" wire:click="deleteTask({{ $task->id }})"><i
                class="fa fa-trash"></i></button>
          </div>
        </div>
      </div>
    @endforeach

    <div class="mt-3">
      {{ $tasks->links() }}
    </div>
  </div>
</div>
