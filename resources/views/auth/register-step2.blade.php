<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo/>
        </x-slot>

        <x-jet-validation-errors class="mb-4"/>

        <form method="POST" action="{{ route('register-step2.post') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label for="phone" value="{{ __('Phone') }}"/>
                <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="address" value="{{ __('Address') }}"/>
                <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')"/>
            </div>

            <div class="mt-4">
                <x-jet-label for="city_id" value="{{ __('City') }}"/>
                <select name="city_id"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="photo" value="{{ __('Profile photo') }}"/>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <input type="file" name="photo" class="opacity-10" />
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button class="ml-4">
                    {{ __('Finish Registration') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
