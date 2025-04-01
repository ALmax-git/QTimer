<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ModelsTodo;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;

class Todo extends Component
{
    use WithPagination, Actions;

    public $task, $description, $due_date, $priority = 'medium', $search = '', $status = '';
    public $editId = null;

    protected $paginationTheme = 'bootstrap';

    public function updated($field)
    {
        if (in_array($field, ['search', 'status', 'priority'])) {
            $this->resetPage();
        }
    }

    public function addTask()
    {
        $this->validate([
            'task' => 'required|string|min:3',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        ModelsTodo::create([
            'user_id' => Auth::id(),
            'title' => $this->task,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'priority' => $this->priority,
            'status' => 'pending',
        ]);

        $this->reset(['task', 'description', 'due_date', 'priority']);
        $this->notification()->success('Task Added', 'Your task has been added successfully!');
    }

    public function editTask($id)
    {
        $todo = ModelsTodo::findOrFail($id);
        if ($todo->user_id == Auth::id()) {
            $this->editId = $id;
            $this->task = $todo->title;
            $this->description = $todo->description;
            $this->due_date = $todo->due_date;
            $this->priority = $todo->priority;
        }
    }

    public function updateTask()
    {
        if (!$this->editId) return;

        $this->validate([
            'task' => 'required|string|min:3',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $todo = ModelsTodo::findOrFail($this->editId);
        if ($todo->user_id == Auth::id()) {
            $todo->update([
                'title' => $this->task,
                'description' => $this->description,
                'due_date' => $this->due_date,
                'priority' => $this->priority,
            ]);
        }

        $this->reset(['editId', 'task', 'description', 'due_date', 'priority']);
        $this->notification()->success('Task Updated', 'Your task has been updated successfully!');
    }

    public function deleteTask($id)
    {
        $todo = ModelsTodo::findOrFail($id);
        if ($todo->user_id == Auth::id()) {
            $todo->delete();
            $this->notification()->success('Task Deleted', 'Task has been removed!');
        }
    }

    public function render()
    {
        $tasks = ModelsTodo::where('user_id', Auth::id())
            ->when($this->search, fn($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->priority, fn($query) => $query->where('priority', $this->priority))
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.todo', compact('tasks'));
    }
}
