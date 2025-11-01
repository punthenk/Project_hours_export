@props([
    'title' => 'Warning',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmRoute' => '#'
])

<button type="button" command="show-modal" commandFor="dialog-{{ $attributes->get('id') ?? 'default' }}"
    class="popup-open-button rounded-md px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-950/10">
    {{ $slot }}
</button>

<dialog id="dialog-{{ $attributes->get('id') ?? 'default' }}"
    class="fixed inset-0 overflow-y-auto bg-transparent backdrop:bg-transparent">
    <div class="fixed inset-0 bg-gray-500/75"></div>

    <div class="flex min-h-full items-center justify-center p-4 text-center">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:w-full sm:max-w-lg">
            <div class="bg-white px-6 pt-5 pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-gray-600">{{ $message }}</p>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 sm:flex sm:flex-row-reverse">
                <form action="{{ $confirmRoute }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-500 sm:ml-3 sm:w-auto">
                        {{ $confirmText }}
                    </button>
                </form>
                <button type="button"
                        command="close"
                        commandfor="dialog-{{ $attributes->get('id') ?? 'default' }}"
                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                    {{ $cancelText }}
                </button>
            </div>
        </div>
    </div>
</dialog>
