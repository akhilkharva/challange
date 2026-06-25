<?php

use App\Models\Task;
use Livewire\Volt\Component;

new class extends Component {
    public string $title = '';

    public function addTask(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        Task::create(['title' => $this->title, 'completed' => false]);

        $this->reset('title');
    }

    public function toggle(int $id): void
    {
        $task = Task::findOrFail($id);
        $task->update(['completed' => ! $task->completed]);
    }

    public function with(): array
    {
        return ['tasks' => Task::latest()->get()];
    }
}; ?>

<div>
    <form wire:submit="addTask">
        <input type="text" wire:model="title" placeholder="New task title" />
        <button type="submit">Add</button>
        @error('title') <span>{{ $message }}</span> @enderror
    </form>

    <ul>
        @foreach ($tasks as $task)
            <li wire:key="{{ $task->id }}">
                <button wire:click="toggle({{ $task->id }})">
                    {{ $task->completed ? '✓' : '○' }}
                </button>
                {{ $task->title }}
            </li>
        @endforeach
    </ul>
</div>
