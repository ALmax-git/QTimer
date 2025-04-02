<div class="container-fluid pt-4" style="min-height: 80vh;">
  <div>
    <x-notifications />
  </div>

  <div class="h-100 bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="mb-0">To Do List</h6>
      {{-- <a href="#">Show All</a> --}}
    </div>

    <div class="d-flex mb-2">
      <input class="form-control me-2 bg-transparent" type="text" wire:model.live="search" placeholder="Search task">
      <select class="form-select me-2 bg-transparent" wire:model.live="priority">
        <option value="">All Priorities</option>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>
      <button class="btn btn-primary" wire:click="open_model">Add</button>
    </div>
    @if ($model)
      <div class="mb-3">
        <input class="form-control bg-transparent" type="text" wire:model="task" placeholder="Task title">
        <textarea class="form-control mt-2 bg-transparent" wire:model="description" placeholder="Task description"></textarea>
        <input class="form-control mt-2 bg-transparent" type="date" wire:model="due_date">
        <select class="form-select mt-2 bg-transparent" wire:model.live="priority">
          <option value="">Choose</option>
          <option value="low">Low</option>
          <option value="medium" selected>Medium</option>
          <option value="high">High</option>
        </select>
        <button class="btn btn-primary mt-2" wire:click="{{ $editId ? 'updateTask' : 'addTask' }}">
          {{ $editId ? 'Update Task' : 'Add Task' }}
        </button>
        <button class="btn btn-primary mt-2" wire:click="close_model">
          Cancel
        </button>
      </div>
    @endif

    <table class="table-striped table-hover table-sm table">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th style="width: 10vw;">Title</th>
          <th style="width: 35vw;">Description</th>
          <th>Due Date</th>
          <th>Priority</th>
          <th>Status</th>
          <th style="text-align: right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($tasks as $index => $task)
          <tr>
            <td>
              {{ $loop->iteration }}
            </td>
            <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
              {{ $task->title }}
            </td>
            <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
              {{ $task->description }}
            </td>
            <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
              {{ $task->due_date }}
            </td>
            <td>
              <span
                class="badge {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                {{ ucfirst($task->priority) }}
              </span>
            </td>
            <td>
              <span class="badge {{ $task->status === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                {{ ucfirst($task->status) }}
              </span>
            </td>
            <td style="text-align: right;">
              <input class="form-check-input btn btn-outline-primary m-1" type="checkbox"
                wire:click="toggleStatus({{ $task->id }})" {{ $task->status === 'completed' ? 'checked' : '' }}>
              <button class="btn btn-sm btn-outline-primary" wire:click="editTask({{ $task->id }})">
                <i class="fa fa-edit"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" wire:click="deleteTask({{ $task->id }})">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
        @empty
          <tr>
            <td class="text-muted text-center" colspan="7">No tasks found.</td>
          </tr>
        @endforelse
      </tbody>
    </table>

    <div class="mt-3">
      {{ $tasks->links() }}
    </div>

  </div>
</div>
