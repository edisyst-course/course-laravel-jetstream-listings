<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add new listing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-jet-validation-errors class="mb-4" />   {{--GESTISCE TUTTI GLI ERRORI DI VALIDAZIONE--}}

            <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">
                @csrf

                <div>
                    <x-jet-label for="title" value="{{ __('Title') }}" />
                    <x-jet-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="description" value="{{ __('Description') }}" />
                    <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                              name="description">{{ old('description') }}</textarea>
                </div>

                <div class="mt-4">
                    <x-jet-label for="price" value="{{ __('Price') }}" />
                    <x-jet-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="photo1" value="{{ __('Photo 1') }}" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <input type="file" name="photo1" class="opacity-10" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-jet-label for="photo2" value="{{ __('Photo 2') }}" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <input type="file" name="photo2" class="opacity-10" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-jet-label for="photo3" value="{{ __('Photo 3') }}" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <input type="file" name="photo3" class="opacity-10" />
                    </div>
                </div>

                <div class="mt-4">
                    <x-jet-label for="categories" value="{{ __('Categories') }}" />
                    @foreach($categories as $category)
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" />
                        {{ $category->name }}
                        <br />
                    @endforeach
                </div>

                <div class="mt-4">
                    <x-jet-label for="sizes" value="{{ __('Sizes') }}" />
                    @foreach($sizes as $size)
                        <input type="checkbox" name="sizes[]" value="{{ $size->id }}" />
                        {{ $size->name }}
                        <br />
                    @endforeach
                </div>

                <div class="mt-4">
                    <x-jet-label for="colors" value="{{ __('Colors') }}" />
                    @foreach($colors as $color)
                        <input type="checkbox" name="colors[]" value="{{ $color->id }}" />
                        {{ $color->name }}
                        <br />
                    @endforeach
                </div>

                <div class="flex items-center mt-6">
                    <x-jet-button>
                        {{ __('Save listing') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
