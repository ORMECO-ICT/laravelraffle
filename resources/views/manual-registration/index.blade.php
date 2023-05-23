<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manual Registrations') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">

                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @else
                        <x-validation-errors class="mb-4" />
                    @endif

                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        Assigned Venue
                    </h1>

                    <div class="mt-6 text-gray-500 leading-relaxed">
                        <h3>{{ $venue['code'] }} : {{ $venue['name'] }}</h3>

                        {{-- @if (count($venue['towns']) > 0)
                            <ul class="text-black">
                                <li>
                                    <h5>Coverage</h5>
                                </li>
                                @foreach ($venue['towns'] as $town)
                                    <li>> {{ $town }}</li>
                                @endforeach
                            </ul>
                        @endif --}}
                    </div>
                </div>
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        List of Registered
                    </h1>
                    @if($venue['code']!='')
                    <a href="{{ route('verify.') }}" class="btn btn-success w-1x1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </a>
                    @endif
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $dataTable->table() }}

                        @push('js')
                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

                            <script>
                                window.addEventListener('onSuccess', (e) => {
                                    console.log('onSuccess');
                                    //refresh data of table
                                    window.LaravelDataTables["table_manual_registration"].draw(true);
                                });
                            </script>
                        @endpush
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
