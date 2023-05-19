<form wire:submit.prevent="draw">
    <input type="hidden" id="draw-number" wire:model="draw_number">
    <button class="solid-button {{$draw_enabled!='Y'? 'hidden' : ''}}" id="draw-button" type="submit" >Draw</button>
    <x-validation-errors class="mb-2" />
    <div class="mt-2">
        <span id="draw-venue" wire:click="fetchDrawDetails()">Venue: <b>{{$draw_venue_name}}</b></span>
        <span id="draw-next" wire:click="fetchDrawDetails()" class="ml-2">Next Draw: #<b>{{$draw_number}}</b></span>
        <hr style="margin:0;">
        <div id="draw-prize" wire:click="fetchDrawDetails()" class="mt-2" style="font-size:2em;" >Prize: <b>{{$draw_prize_name}}</b></div>
    </div>
</form>
