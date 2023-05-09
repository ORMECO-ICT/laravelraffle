<?php

namespace App\Http\Livewire\Draw;

use Livewire\Component;
use App\Models\ConsumerData;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;

class Slot extends Component
{

    public $draw_number = 1;
    public $draw_prize = 1;

    public function mount()
    {
        $this->getLastDrawNumber();
    }

    public function render()
    {
        // $number = $this->draw_number;
        // return view('livewire.draw.slot', compact('number'));
        return view('livewire.draw.slot');
    }

    private function getLastDrawNumber()
    {
        $result = DB::select("SELECT COALESCE(MAX(win_draw),1) as 'number' FROM raffle_winner");
        $this->draw_number = $result[0]->number;
    }

    public function drawNumber()
    {
        $this->dispatchBrowserEvent('onDrawNumber', ['number'=> $this->draw_number]);
    }

    public function draw()
    {
        $validatedData = $this->validate([
            'draw_number' => 'required|min:1',
            'draw_prize' => 'required',
        ]);

        $this->draw_number = $validatedData['draw_number'];

        $venue = Settings::where('code', 'VENUE')->first();
        $luck_draw = DB::select("CALL sp_lucky_draw('" . $venue->value . "', 'N')");
        $winner = [
            'number'=> $this->draw_number,
            // 'number'=> $luck_draw[0]->win_draw,
            'account_no'=> $luck_draw[0]->account_no,
            'account_code'=> $luck_draw[0]->account_code,
            'consumer_name'=> $luck_draw[0]->consumer_name,
            'address'=> $luck_draw[0]->address,
        ];

        $entries = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(39)->get()->pluck('raffle_entry')->toArray();
        // $winner = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(1)->first();

        array_push($entries, ConsumerData::formatEntry($winner['account_no'], $winner['account_code'], $winner['consumer_name']));
        $this->dispatchBrowserEvent('onDraw', ['entries'=> $entries, 'winner'=> $winner]);

        $this->draw_number = $this->draw_number + 1;
    }



}
