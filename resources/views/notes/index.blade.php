<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ request()->routeIs('notes.index') ? __('Notes') : __('Trash') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-alert-success>
                {{ session('success') }}
            </x-alert-success>

            @if (request()->routeIs('notes.index'))
                <a href="{{ route('notes.create') }}" class="btn-link btn-lg mb-2">+ New Note</a>
            @endif

            @forelse ($notes as $note)
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                    <h1 class="font-bold text-2xl">
                        <a href="{{ !$note->trashed() ? route('notes.show', $note) : route('trashed.show', $note) }}">
                            {{ $note->title }}
                        </a>
                    </h1>
                    <p class="mt-2">
                        {{ Str::limit($note->text, 200, '...') }}
                    </p>
                    <span class="block mt-4 opacity-70 text-sm">
                        {{ $note->updated_at->diffForHumans() }}
                    </span>
                </div>
            @empty
            @if (request()->routeIs('notes.index'))
                <p>you have no note yet.</p>
            @else
                <p>no items in the trash.</p>
            @endif
            @endforelse
            {{ $notes->links() }}

        </div>
    </div>
</x-app-layout>
