<nav class="flex items-center gap-2">
    @auth
        <x-ui.button variant="primary" size="sm" type="link" href="{{ route('todos') }}" wire:navigate>
            My tasks
        </x-ui.button>
    @else
        <x-ui.button variant="ghost" size="sm" type="link" href="{{ route('login') }}" wire:navigate>
            Log in
        </x-ui.button>

        @if (Route::has('register'))
            <x-ui.button variant="primary" size="sm" type="link" href="{{ route('register') }}" wire:navigate>
                Register
            </x-ui.button>
        @endif
    @endauth
</nav>
