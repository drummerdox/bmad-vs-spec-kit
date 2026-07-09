<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Tasks') }}
        </h2>
    </x-slot>

    <div class="bg-gradient-to-b from-indigo-50/40 to-gray-100 py-10 sm:py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <livewire:todo-list />
        </div>
    </div>
</x-app-layout>
