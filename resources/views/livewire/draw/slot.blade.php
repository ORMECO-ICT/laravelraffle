<form wire:submit.prevent="draw">
    <input type="hidden" id="draw-number" wire:model="draw_number">
    <input type="hidden" id="draw-prize" wire:model="draw_prize">
    <button class="solid-button" id="draw-button" type="submit">Draw #{{$draw_number}}</button>
</form>
