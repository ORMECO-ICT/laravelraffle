<x-draw-layout>
    <div class="theme--red" id="app">
        <div class="main">
            <div class="control-group">
                <button class="icon-button icon-button--small" id="fullscreen-button">
                    <x-draw.button-fullscreen />
                </button><button class="icon-button icon-button--small" id="settings-button">
                    <x-draw.button-settings />
                </button>
                <a class="icon-button icon-button--small" id="dashboard-button" href="{{ route('dashboard') }}">
                    <x-draw.button-dashboard />
                </a>
            </div>
            <canvas class="confetti" id="confetti-canvas"></canvas>
            <div id="lucky-draw">
                {{-- <img
              class="title"
              src="{{asset('assets/img/title.svg')}}"
              alt="Lucky Draw"
            /> --}}
                {{-- <div class="banner">
                ORMECO, Inc.<br/>
                41st AGMA RAFFLE DRAW
            </div> --}}
                {{-- <div class="grid"></div> --}}

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
                <div class="settings__panel" id="settings-panel">
                    <div class="settings__panel__group">
                        <h1 class="settings__title">Settings</h1>
                        <div class="input-group">
                            <label class="input-label" for="name-list">Name List</label>
                            <textarea class="input-field input-field--textarea" rows="8" placeholder="Separate each name by line break"
                                id="name-list"></textarea>
                        </div>
                        <div class="input-group input-group--2-column">
                            <label class="input-label" for="remove-from-list">Remove winner from list</label><label
                                class="input--switch"><input type="checkbox" checked="true"
                                    id="remove-from-list" /><span class="slider"></span></label>
                        </div>
                        <div class="input-group input-group--2-column">
                            <label class="input-label" for="enable-sound">Enable sound effect</label><label
                                class="input--switch"><input type="checkbox" checked="true" id="enable-sound" /><span
                                    class="slider"></span></label>
                        </div>
                    </div>
                    <div class="settings__panel__group">
                        <button class="solid-button solid-button" id="settings-save">
                            Save</button><button class="solid-button solid-button--danger" id="settings-close">
                            Discard and close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <span>© Ice Lam 2023・</span><a href="https://github.com/icelam/random-name-picker"
                target="_blank">Github</a>
        </div>
</x-draw-layout>
