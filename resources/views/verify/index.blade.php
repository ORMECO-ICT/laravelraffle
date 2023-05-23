<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Account') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        Consumer Records
                    </h1>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $dataTable->table() }}

                        @push('js')
                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

                            <script>
                                window.addEventListener('onSuccess', (e) => {
                                    console.log('onSuccess');
                                    //refresh data of table
                                    window.LaravelDataTables["table_consumers"].draw(true);
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
