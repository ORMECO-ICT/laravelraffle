<form wire:submit.prevent="draw">
    <input type="hidden" id="draw-number" wire:model="draw_number">
    <button class="solid-button" id="draw-button" type="submit">Draw</button>
    <x-validation-errors class="mb-4" />
    <div id="draw-next">Next Draw: #{{$draw_number}}</div>
</form>
