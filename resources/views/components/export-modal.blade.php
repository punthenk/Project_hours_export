<!-- resources/views/components/export-modal.blade.php -->
@props([
    'projectId',
    'route' => 'project.export'
])

<!-- Export Button Trigger -->
<button type="button"
    data-project_id="{{ $projectId }}"
    class="export-project-btn text-gray-900 rounded-md px-2.5 py-1.5 text-sm font-semibold hover:bg-gray-900 hover:text-white transition">
    Export
</button>

<!-- Modal -->
<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h2 class="text-xl font-semibold mb-4">Export Opties</h2>

        <form action="{{ route($route, $projectId) }}" method="POST" class="space-y-4">

            <!-- Week Number -->
            <div>
                <label class="block text-sm text-gray-700 mb-1">Week Number</label>
                <input type="number"
                    name="week_number"
                    min="1"
                    max="53"
                    value="{{ date('W') }}"
                    placeholder="Week number"
                    class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200"
                    required>
                <p class="mt-1 text-xs text-gray-500">Current week: {{ date('W') }}</p>
            </div>

            <!-- Year -->
            <div>
                <label class="block text-sm text-gray-700 mb-1">Year</label>
                <input type="number"
                    name="year"
                    min="2020"
                    max="2030"
                    value="{{ date('Y') }}"
                    placeholder="Jaar"
                    class="w-full border-none rounded-lg px-3 py-2 text-sm bg-gray-200"
                    required>
            </div>

            <!-- Include Weekend -->
            <div class="flex items-center">
                <input type="checkbox"
                    id="include_weekend_{{ $projectId }}"
                    name="include_weekend"
                    value="1"
                    class="w-4 h-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900">
                <label for="include_weekend_{{ $projectId }}" class="ml-2 text-sm text-gray-700 cursor-pointer">
                    Weekend days included
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2">
                <button type="button"
                    class="px-4 py-2 text-sm border rounded hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 text-sm bg-gray-900 text-white rounded hover:bg-gray-800">
                    Export
                </button>
            </div>
        </form>
    </div>
</div>
