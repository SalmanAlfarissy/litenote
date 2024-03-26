<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <form action="{{ route('notes.store') }}" method="POST">
                    @method('POST')
                    @csrf
                    <x-text-input
                    name="title"
                    type="text"
                    class="w-full"
                    :value="old('title')"
                    autocomplete='off'
                    placeholder='Title'
                    />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />

                    <x-textarea
                    name='text'
                    class="w-full mt-10"
                    field='text'
                    placeholder='start typing here...'
                    rows="10"
                    :value="old('text')"
                    />
                    <x-input-error :messages="$errors->get('text')" class="mt-2" />

                    <x-secondary-button type="submit" class="mt-6"> Save </x-secondary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
