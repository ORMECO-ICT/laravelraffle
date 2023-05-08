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

    <div class="reel-winner">
        <div id="winner-name" class="fancy"></div>
        <div id="winner-address"></div>
    </div>

    <button wire:click="draw()" class="solid-button" id="draw-button">Draw</button>
</div>
