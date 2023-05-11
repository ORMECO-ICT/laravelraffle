<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ORMECO, Inc. - 41st AGMA Raffle') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        List of Winners
                    </h1>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        {{ $dataTable->table() }}

                        @push('js')
                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
                        @endpush
                    </p>
                </div>
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        Selected Venue/District
                    </h1>

                    <div class="mt-6 text-gray-500 leading-relaxed">
                        <h3>{{ $venue['code'] }} : {{ $venue['name'] }}</h3>

                        @if(count($venue['towns'])>0)
                        <ul class="text-black">
                            <li><h5>Coverage</h5></li>
                            @foreach($venue['towns'] as $town)
                                <li>> {{$town}}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <h1 class="mt-4 text-2xl font-medium text-gray-900">
                        Selected Prize
                    </h1>

                    <div class="mt-6 text-gray-500 leading-relaxed">
                        <h3>{{ $prize['name'] }} : {{ $prize['name'] }}</h3>
                        @if(count($prize['items'])>0)
                        <table class="table dataTable table-striped table-bordered table-hover no-footer">
                            <colgroup>
                                <col width="5%">
                                <col width="15%">
                                <col width="40%">
                                <col width="30%">
                                <col width="5%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prize['items'] as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->prize_category}}</td>
                                    <td>{{$item->prize_name}}</td>
                                    <td>{{$item->prize_desc}}</td>
                                    <td>{{$item->available_units}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
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
