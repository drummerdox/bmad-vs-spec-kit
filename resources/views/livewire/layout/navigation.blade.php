<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="border-b border-gray-100 bg-surface-elevated/90 backdrop-blur-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <x-brand.logo href="{{ route('todos') }}" />
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('todos')" :active="request()->routeIs('todos')" wire:navigate>
                        {{ __('Todos') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:ms-6 sm:flex sm:items-center">
                <button
                    type="button"
                    wire:click="logout"
                    class="inline-flex items-center rounded-xl px-3 py-2 text-sm font-medium text-muted motion-safe-transition hover:text-ink focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    {{ __('Log Out') }}
                </button>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl p-2 text-muted motion-safe-transition hover:bg-gray-100 hover:text-ink focus:bg-gray-100 focus:text-ink focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
            <x-responsive-nav-link :href="route('todos')" :active="request()->routeIs('todos')" wire:navigate>
                {{ __('Todos') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 pb-3 pt-2">
            <button
                type="button"
                wire:click="logout"
                class="block w-full ps-3 pe-4 py-2 text-start text-base font-medium text-muted hover:bg-gray-50 hover:text-ink"
            >
                {{ __('Log Out') }}
            </button>
        </div>
    </div>
</nav>
