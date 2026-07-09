<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-ink">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="bg-surface-mesh py-10 sm:py-12">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <livewire:todo-list />
        </div>
    </div>
</x-app-layout>
