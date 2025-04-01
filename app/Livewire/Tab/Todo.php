<?php

namespace App\Livewire\Tab;

use App\Models\Todo as ModelsTodo;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Todo extends Component
{
    use WithPagination;

    public $task, $search = '', $perPage = 5;
    public $sortField = 'created_at', $sortDirection = 'desc';

    protected $queryString = ['search', 'perPage', 'sortField', 'sortDirection'];

    protected $listeners = ['taskDeleted' => 'render'];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination on search change
    }

    public function addTask()
    {
        $this->validate([
            'task' => 'required|string|min:3',
        ]);

        ModelsTodo::create([
            'user_id' => Auth::id(),
            'title' => $this->task,
            'status' => 'pending',
        ]);

        $this->task = '';
        $this->resetPage();
    }

    public function toggleStatus($id)
    {
        $todo = ModelsTodo::find($id);
        if ($todo && $todo->user_id == Auth::id()) {
            $todo->status = $todo->status === 'completed' ? 'pending' : 'completed';
            $todo->save();
        }
    }

    public function deleteTask($id)
    {
        $todo = ModelsTodo::find($id);
        if ($todo && $todo->user_id == Auth::id()) {
            $todo->delete();
            $this->emit('taskDeleted'); // Refresh the list
        }
    }

    public function setSort($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $todos = ModelsTodo::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhere('priority', 'like', "%{$this->search}%");
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.tab.todo', compact('todos'));
    }
}
