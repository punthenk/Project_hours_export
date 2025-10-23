<x-app-layout>
    <div class="">
        <div class="max-w-4xl mx-auto">
            <div class="mb-12">
                <div class="flex items-baseline justify-between mb-2">
                    <h1>Projects</h1>
                    <button id="new-project-btn"
                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive border bg-background text-foreground hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50 h-9 px-4 py-2 gap-2 bg-white hover:bg-gray-300 hover:border-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-plus size-4" aria-hidden="true">
                            <path d="M5 12h14"></path>
                            <path d="M12 5v14"></path>
                        </svg>
                        New Project
                    </button>
                </div>
                <p class="text-gray-600">
                    {{ $projects->count() }} {{ Str::plural('project', $projects->count()) }}
                </p>
            </div>

            <div class="">
                @forelse ($projects as $project)
                <a href="/project/{{ $project->id }}"
                    class="group flex items-center gap-6 py-4 px-6 -mx-6 hover:bg-gray-200 transition-colors cursor-pointer border-b border-gray-200 last:border-0 block">
                    <div class="w-1 h-12 rounded-full shrink-0" style="background-color: rgb(123, 137, 168);"></div>
                    <div class="flex-1 min-w-0">
                        <h3 class="mb-1 font-semibold">{{ $project->name }}</h3>
                    </div>
                    <div class="flex items-center gap-8 shrink-0">
                        <div class="text-right">
                            <div class="text-gray-600">Tasks</div>
                            <div>{{ $project->completed_tasks_count }} / {{ $project->tasks->count() }}</div>
                        </div>
                        <div class="text-right min-w-[80px]">
                            <div class="text-gray-600">Time</div>
                            <div>{{ $project->total_worked_time }}</div>
                        </div>
                        <x-popup id="delete-task-{{ $project->id }}" title="WARNING"
                            message="Are you sure you want to delete this project? This action can not be undone."
                            confirmText="Delete" confirmRoute="{{ route('projects.destroy', $project->id) }}">
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
                </a>
                @empty
                <p>No projects yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- New Project Modal -->
    <div id="new-project-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-xl font-semibold mb-4">Create Project</h2>
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Project Name"
                    class="w-full border border-gray-300 rounded px-3 py-2">
                <input type="color" name="color" class="w-full h-10 rounded">
                <div class="flex justify-end gap-2">
                    <button type="button" id="modal-cancel"
                        class="border border-gray-300 px-4 py-2 rounded">Cancel</button>
                    <button type="submit" class="bg-gray-900 text-white px-4 py-2 rounded">Create</button>
                </div>
            </form>
        </div>
    </div>

    <!-- User info modal -->
    <div id="user-info-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h2 class="text-xl font-semibold mb-4">Account Info</h2>
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                @csrf
                <p>Username: <span class="font-bold">{{ Auth::user()->name }}</span></p>
                <p>Email: <span class="font-bold">{{ Auth::user()->email }}</span></p>
                <p>Last updated at: <span class="font-bold">{{ Auth::user()->updated_at->toDateString() }}</span></p>
                <p>Account created at: <span class="font-bold">{{ Auth::user()->created_at->toDateString() }}</span></p>
                <div class="flex justify-end gap-2">
                    <button type="button" id="user-modal-close"
                        class="border border-gray-300 px-4 py-2 rounded">Close</button>
                </div>
            </form>
        </div>
    </div>

    @auth
    <div
        class="fixed bottom-0 left-0 w-full flex items-center justify-between bg-gray-100 text-gray-700 px-6 py-3 border-t border-gray-300">
        <button type="submit" id="open-user-modal-btn"
            class="text-sm text-gray-600 hover:text-gray-900 p-3 hover:bg-gray-300 rounded-lg transition">
            {{ Auth::user()->name }}
        </button>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm text-gray-600 hover:text-gray-900 p-3 hover:bg-gray-300 rounded-lg transition">
                Logout
            </button>
        </form>
    </div>
    @endauth
</x-app-layout>
