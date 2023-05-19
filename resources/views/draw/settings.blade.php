<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Online Raffle Draw Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="max-width: 40rem;">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        Settings
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @else
                            <x-validation-errors class="mb-4" />
                        @endif

                    <form method="POST" action="{{ route('draw.store') }}">
                        @csrf

                        @php
                            // $venues = \DB::table('venue')
                            //     ->select('*')
                            //     ->whereNot('venue_id', 'V00')
                            //     ->get();

                            //    dd($venues);

                        @endphp
                        <div>
                            <x-label for="venue_id" value="{{ __('Target Venue') }}" />
                            <select name="venue_id" id="venue_id"
                                class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2 mt-2"
                                style="width:100%" required autofocus>
                                @foreach ($venues as $v)
                                    <option value="{{ $v['id'] }}"
                                        {{ $v['id'] == (old('venue_id') == '' ? $settings_venue : old('venue_id')) ? 'selected' : '' }}>
                                        {{ $v['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="setter_venue" value="{{ __('Last updated by') }}" />
                            <x-input id="setter_venue" class="block mt-1 w-full" type="text" name="setter_venue" :value="$setter_venue" required autofocus autocomplete="setter_venue"  readonly/>
                        </div>

                        <hr>

                        @php
                            $prizes = \DB::table('raffle_prize')
                                ->select('*')
                                // ->where('prize_category', 'Minor Prize')
                                ->orderBy('prize_units', 'desc')
                                ->get();
                        @endphp
                        <div class="mt-4">
                            <x-label for="prize_id" value="{{ __('Prize') }}" />
                            <select name="prize_id" id="prize_id"
                                class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-2 mt-2"
                                style="width:100%" required autofocus>
                                @foreach ($prizes as $v)
                                    <option value="{{ $v->id }}"
                                        {{ $v->id == (old('prize_id') == '' ? $settings_prize : old('prize_id')) ? 'selected' : '' }}>
                                        {{ $v->prize_category }} | {{ $v->prize_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="setter_prize" value="{{ __('Last updated by') }}" />
                            <x-input id="setter_prize" class="block mt-1 w-full" type="text" name="setter_prize" :value="$setter_prize" required autofocus autocomplete="setter_prize"  readonly/>
                        </div>


                        <div class="flex items-center justify-end mt-4">
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
