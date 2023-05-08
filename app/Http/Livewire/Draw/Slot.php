<?php

namespace App\Http\Livewire\Draw;

use Livewire\Component;
use App\Models\ConsumerData;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;

class Slot extends Component
{
    public $has_winner = false;
    public $is_spinning = false;

    public function render()
    {
        return view('livewire.draw.slot');
    }

    public function draw()
    {
        $venue = Settings::where('code', 'VENUE')->first();
        $luck_draw = DB::select("CALL sp_lucky_draw('" . $venue->value . "', 'N')");
        $winner = [
            'number'=> $luck_draw[0]->win_draw,
            'account_no'=> $luck_draw[0]->account_no,
            'account_code'=> $luck_draw[0]->account_code,
            'consumer_name'=> $luck_draw[0]->consumer_name,
            'address'=> $luck_draw[0]->address,
        ];

        $entries = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(39)->get()->pluck('raffle_entry')->toArray();
        // $winner = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(1)->first();

        array_push($entries, ConsumerData::formatEntry($winner['account_no'], $winner['account_code'], $winner['consumer_name']));
        $this->dispatchBrowserEvent('onDraw', ['entries'=> $entries, 'winner'=> $winner]);
    }
}
