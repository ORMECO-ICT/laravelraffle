<form wire:submit.prevent="draw">
    <input type="hidden" id="draw-number" wire:model="draw_number">
    <button class="solid-button" id="draw-button" type="submit">Draw</button>
    <x-validation-errors class="mb-2" />
    <div class="mt-2">
        <span id="draw-venue">Venue: <b>{{$draw_venue_name}}</b></span>
        <span id="draw-next" class="ml-2">Next Draw: #<b>{{$draw_number}}</b></span>
        <span id="draw-prize" class="ml-2">Prize: <b>{{$draw_prize_name}}</b></span>
    </div>
</form>
