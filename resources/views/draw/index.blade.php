<x-draw-layout>
    <div class="theme--red" id="app">
        <div class="main">
            <div class="control-group">
                <button class="icon-button icon-button--small" id="fullscreen-button">
                    <x-draw.button-fullscreen />
                </button><button class="icon-button icon-button--small" id="settings-button">
                    <x-draw.button-settings />
                </button>
                <a class="icon-button icon-button--small" id="dashboard-button" href="{{ route('dashboard.') }}">
                    <x-draw.button-dashboard />
                </a>
            </div>
            <canvas class="confetti" id="confetti-canvas"></canvas>
            <div id="lucky-draw">

                <div class="banner"">
                    <div>
                        <span class="sticker sticker-lg" data-text="41"><span>41</span></span>
                        <span class="sticker sticker" data-text="st"><sub>st</sub> </span>
                        <span class="sticker sticker-lg" data-text="AGMA"><span>AGMA</span></span>
                    </div>

                    <span class="sticker" data-text="ORMECO, Inc." style="--shine-angle: 8deg;"><span>ORMECO,
                            Inc.</span></span>
                </div>

                <div>
                    <div class="slot">
                        <div class="slot__outer">
                            <div class="slot__inner">
                                <div class="slot__shadow"></div>
                                <div class="reel" id="reel"></div>
                            </div>
                        </div>
                        <div class="sunburst" id="sunburst">
                            <img src="{{ asset('assets/img/sunburst.svg') }}" alt="sunburst" />
                        </div>
                    </div>

                    @livewire('draw.slot')

                    <div class="reel-winner">
                        <div class="winner__container">
                            <div class="flex_name">
                                <div id="winner-name" class="winner__name fancy"></div>
                                <div id="winner-address" class="winner__address"></div>
                            </div>
                            <div class="flex_number">
                                ****** WINNER NUMBER : <span id="winner-number" class="winner__number"></span> ******
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="settings" id="settings">
                <div class="settings__panel" id="settings-panel" >
                    <div class="settings__panel__group">
                        <button class="solid-button solid-button" style="display:none" id="settings-save">Save</button>
                        <button class="solid-button solid-button--danger" style="margin: 1rem; width:20%; float:right;" id="settings-close">Close</button>
                    </div>
                    <div class="settings__panel__group">
                        <div class="input-group" style="display:none">
                            <label class="input-label" for="name-list">Name List</label>
                            <textarea class="input-field input-field--textarea" rows="8" placeholder="Separate each name by line break"
                                id="name-list"></textarea>
                        </div>
                        <div class="input-group input-group--2-column" style="display:none">
                            <label class="input-label" for="remove-from-list">Remove winner from list</label><label
                                class="input--switch"><input type="checkbox" checked="true"
                                    id="remove-from-list" /><span class="slider"></span></label>
                        </div>
                        <div class="input-group input-group--2-column" style="display:none">
                            <label class="input-label" for="enable-sound">Enable sound effect</label><label
                                class="input--switch"><input type="checkbox" checked="true" id="enable-sound" /><span
                                    class="slider"></span></label>
                        </div>

                        {{-- {{ $dataTable->table() }}

                        @push('js')
                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
                        @endpush --}}

                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                                    <h1 class="settings__title">List of Winners</h1>

                                    <p class="mt-6 text-gray-500 leading-relaxed">
                                        {{ $dataTable->table() }}

                                        @push('js')
                                            {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
                                        @endpush
                                    </p>
                                </div>
                                <hr>
                                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                                    <h1 class="settings__title">Selected Venue/Municipality</h1>
                                    <div class="mt-6 text-gray-500 leading-relaxed">
                                        <h3>{{ $venue['code'] }} : {{ $venue['name'] }}</h3>
{{--
                                        @if(count($venue['towns'])>0)
                                        <ul class="text-black">
                                            <li><h5>Coverage</h5></li>
                                            @foreach($venue['towns'] as $town)
                                                <li>> {{$town}}</li>
                                            @endforeach
                                        </ul>
                                        @endif --}}
                                    </div>
                                </div>
                                <hr>
                                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                                    <h1 class="settings__title">Selected Prize</h1>
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
                </div>
            </div>
        </div>
        <div class="footer">
            <span>© Ice Lam 2023・</span><a href="https://github.com/icelam/random-name-picker"
                target="_blank">Github</a>
        </div>
</x-draw-layout>
