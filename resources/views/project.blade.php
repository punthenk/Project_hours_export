<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <!-- Back Button -->
        <a href="/"><button
                class="flex items-center text-sm text-gray-600 hover:bg-gray-300 hover:text-gray-800 transition p-2 rounded-lg mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Projects
            </button></a>

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-semibold">{{ $project->name }}</h1>
            <span class="text-sm text-gray-600">Total: {{ $project->total_worked_time }}</span>
        </div>

        <!-- Time Entry -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">Manual Time Entry</h3>
            <form method="POST" action="{{ route('sessions.store' ) }}" id="session-form">
                @csrf
                <div class="grid grid-cols-[1fr_1fr_auto_auto] gap-4 mb-6 items-end">
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">Started Working</label>
                        <input type="time" id="started_at" name="started_at" value="{{ old('started_at') }}"
                            class="@error('started_at') focus:ring-red-500 text-red @enderror w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">Stopped Working</label>
                        <input type="time" id="stopped_at" name="stopped_at" value="{{ old('stopped_at') }}" proje.
                            class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500 mb-1">Task</label>
                        <select name="task_id" id="task_dropdown"
                            class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">
                            @if($project->tasks->isEmpty())
                            <option value="">No tasks available. Please create a task first.</option>
                            @else
                            <option value="">Select a task</option>
                            @foreach($project->tasks as $task)
                            <option value="{{ $task->id }}">{{ $task->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <button id="add-session-btn"
                            class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-1 h-9 rounded-lg disabled:bg-gray-400"
                            disabled>+ Add Session</button>
                    </div>
                </div>
                @if ($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                    <li class="text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </form>

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Live Timer</p>
                    <p class="text-4xl">00:00:00</p>
                </div>
                <button class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-md">Start</button>
            </div>
        </div>

        <!-- Tasks -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Tasks</h3>
                <div class="flex gap-2">
                    <button id="filterButton"
                        class="text-sm hover:bg-gray-200 border-none rounded px-3 py-1 transition">
                        All Tasks
                    </button>
                    <button id="openTaskModal"
                        class="flex items-center text-sm hover:bg-gray-200 border border-gray-300 rounded px-3 py-1 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Task
                    </button>
                </div>
            </div>

            <div class="space-y-3">
                @forelse ($project->tasks as $task)
                <div class="task-item flex items-start justify-between p-4 border border-gray-200 rounded-lg"
                    data-completed="{{ $task->completed ? 'true' : 'false' }}">
                    <div class="flex gap-3">
                        <input type="checkbox" @checked($task->completed)
                        class="mt-1 task-toggle"
                        data-id="{{ $task->id }}"
                        >
                        <div>
                            <p class="{{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">{{
                                $task->name }}</p>
                            <p class="text-sm text-gray-600">{{ $task->description }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>{{ intdiv($task->worked_time ?? 0, 60) }}h {{ ($task->worked_time ?? 0) % 60 }}m</span>
                        <button data-slot="button"
                            data-id="{{ $task->id }}"
                            data-name="{{ $task->name }}"
                            data-description="{{ $task->description }}"
                            data-worked_time="{{ $task->worked_time }}"
                            class="change-task-button rounded-md px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-pencil size-4" aria-hidden="true">
                                <path
                                    d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z">
                                </path>
                                <path d="m15 5 4 4"></path>
                            </svg></button>
                        <x-popup id="delete-task-{{ $task->id }}" title="WARNING"
                            message="Are you sure you want to delete this task? This action can not be undone and the time you worked on this will be deleted."
                            confirmText="Delete" confirmRoute="{{ route('tasks.destroy', $task->id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-trash2 size-4 text-muted-foreground"
                                aria-hidden="true">
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                <path d="M3 6h18"></path>
                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                        </x-popup>
                    </div>
                </div>
                @empty
                <h2 class="text-gray-600">There are no tasks at the moment. Create one!</h2>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="taskModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h2 class="text-lg font-semibold mb-4">Add New Task</h2>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Task Name</label>
                    <input type="text" name="name" placeholder="Enter task name" value="{{ old('name') }}"
                        class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Description</label>
                    <textarea name="description" placeholder="Enter task description" maxlength="255"
                        class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">{{ old('description')}}</textarea>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="cancelTaskModal"
                        class="px-4 py-2 text-sm border rounded hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-900 text-white rounded hover:bg-gray-800">Add
                        Task</button>
                </div>
            </form>
        </div>
    </div>

    <div id="update-task-modal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden transition-opacity">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <h2 class="text-lg font-semibold mb-4">Edit Task</h2>

            <form class="space-y-4" action="#" method="POST" id="update-task-form">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Task Name</label>
                    <input type="text" name="name" placeholder="Enter task name"
                        class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200">
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Description</label>
                    <textarea name="description" placeholder="Enter task description" maxlength="255"
                        class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200"></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" id="cancel-update-task-modal"
                        class="px-4 py-2 text-sm border rounded hover:bg-gray-100">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-gray-900 text-white rounded hover:bg-gray-800">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
