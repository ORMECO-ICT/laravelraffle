<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual Draw on Venues') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="max-width: 40rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        New Tambiolo Winner
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @else
                            <x-validation-errors class="mb-4" />
                        @endif

                    <form method="POST" action="{{ route('manual-draw.store') }}">
                        @csrf

                        @php
                            $venues = \DB::table('venue')
                                ->select('*')
                                ->whereNot('venue_id', 'V00')
                                ->get();
                        @endphp
                        <div>
                            <x-label for="venue_id" value="{{ __('Assigned Venue') }}" />
                            <select name="venue_id" id="venue_id"
                                class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2 mt-2"
                                style="width:100%" required autofocus>
                                @foreach ($venues as $v)
                                    <option value="{{ $v->venue_id }}"
                                        {{ $v->venue_id == (old('venue_id') == '' ? $venue['code'] : old('venue_id')) ? 'selected' : '' }}>
                                        {{ $v->venue_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        @php
                            $prizes = \DB::table('raffle_prize')
                                ->select('*')
                                ->whereNot('prize_category', 'Minor Prize')
                                ->orderBy('prize_units')
                                ->get();
                        @endphp
                        <div class="mt-4">
                            <x-label for="prize_id" value="{{ __('Prize') }}" />
                            <select name="prize_id" id="prize_id"
                                class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2 mt-2"
                                style="width:100%" required autofocus>
                                @foreach ($prizes as $v)
                                    <option value="{{ $v->id }}" {{ $v->id == old('prize_id') ? 'selected' : '' }}>
                                        {{ $v->prize_category }} | {{ $v->prize_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="account_code" value="{{ __('Account Number') }}" />
                            <x-input id="account_code" class="block mt-1 w-full" type="text" name="account_code"
                                :value="old('account_code')" required autofocus autocomplete="account_code" />
                        </div>

                        <div class="mt-4">
                            <x-label for="consumer_name" value="{{ __('Name') }}" />
                            <x-input id="consumer_name" class="block mt-1 w-full" type="text" name="consumer_name"
                                :value="old('consumer_name')" required autofocus autocomplete="consumer_name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="address" value="{{ __('Address') }}" />
                            <x-input id="address" class="block mt-1 w-full" type="text" name="address"
                                :value="old('address')" required autofocus autocomplete="address" />
                        </div>

                        <div class="mt-4">
                            <x-label for="contact" value="{{ __('Contact') }}" />
                            <x-input id="contact" class="block mt-1 w-full" type="text" name="contact"
                                :value="old('contact')" required autofocus autocomplete="contact" />
                        </div>

                        {{--

                        <div class="mt-4">
                            <x-label for="auth_key" value="{{ __('Registration Key') }}" />
                            <x-input id="auth_key" class="block mt-1 w-full" type="password" name="auth_key" required />
                        </div> --}}

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('manual-draw.') }}">
                                {{ __('Back to list') }}
                            </a>

                            <x-button class="ml-4">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                    </p>
                </div>


            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-welcome /> --}}
            </div>
        </div>
    </div>
</x-app-layout>
