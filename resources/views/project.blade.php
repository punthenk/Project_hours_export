<x-app-layout>
    <div class="">
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
            <span class="text-sm text-gray-600">Total: {{ $project->worked_time }} h</span>
        </div>

        <!-- Time Entry -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4">Manual Time Entry</h3>
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Started Working</label>
                    <input type="time" class="w-full border-none rounded px-3 py-2 text-sm bg-gray-200">
                </div>
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Stopped Working</label>
                    <input type="time" class="w-full border-none rounded px-3 py-2 text-sm bg-gray-200">
                </div>
                <div>
                    <label class="block text-sm text-gray-500 mb-1">Time Worked</label>
                    <input type="text" placeholder="e.g., 2h 30m"
                        class="w-full border-none rounded px-3 py-2 text-sm bg-gray-200">
                </div>
            </div>

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
                <button id="openTaskModal"
                    class="flex items-center text-sm hover:bg-gray-200 border border-gray-300 rounded px-3 py-1 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Task
                </button>
            </div>

            <div class="space-y-3">
                @forelse ($project->tasks as $task)
                <div class="flex items-start justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex gap-3">
                        <input type="checkbox" @checked($task->completed) class="mt-1">
                        <div>
                            <p class="{{ $task->completed ? 'line-through text-gray-500' : 'text-gray-800' }}">{{
                                $task->name }}</p>
                            <p class="text-sm text-gray-600">{{ $task->description }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <span>{{ $task->time_spent ?? '0h 0m' }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 cursor-pointer" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9" />
                        </svg>
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
                    <input type="text" name="name" placeholder="Enter task name"
                        class="w-full border-none rounded px-3 py-2 text-sm bg-gray-200">
                </div>

                <div>
                    <label class="block text-sm text-gray-700 mb-1">Description</label>
                    <textarea name="description" placeholder="Enter task description"
                        class="w-full border-none rounded px-3 py-2 text-sm bg-gray-200"></textarea>
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

    <script src="{{ asset('js/task-modal.js') }}"></script>
</x-app-layout>
