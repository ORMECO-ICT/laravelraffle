<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registration Summary') }}
        </h2>
        <div class="text-gray-500">
            Data as of {{$dateAsOf}}
        </div>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        List of Google Forms Entries
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $dataTable->table() }}

                        @push('js')
                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
                        @endpush
                    </p>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-medium text-gray-900">
                        List of Verified Raffle Entries
                    </h1>
                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $dataTableRaffle->table() }}

                        @push('js')
                            {{ $dataTableRaffle->scripts(attributes: ['type' => 'module']) }}
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
