<?php

namespace App\Http\Livewire\Draw;

use Livewire\Component;
use App\Models\ConsumerData;
use App\Models\RaffleWinner;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;

class Slot extends Component
{

    public $draw_number = 1;
    public $draw_prize_id = 1;
    public $venue_id = '';

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
        $result = DB::select("SELECT COALESCE(MAX(win_draw),0) +1 as 'number' FROM raffle_winner");
        $this->draw_number = $result[0]->number;
    }

    private function getPrizeId()
    {
        $prize = Settings::where('code', 'PRIZE')->first();
        $this->draw_prize_id = $prize->value;
    }

    private function getVenueId()
    {
        $setting = Settings::where('code', 'VENUE')->first();
        $this->venue_id = $setting->value == ''? '00' : $setting->value;
    }

    public function drawNumber()
    {
        $this->dispatchBrowserEvent('onDrawNumber', ['number'=> $this->draw_number]);
    }

    public function draw()
    {
        $validatedData = $this->validate([
            'draw_number' => 'required|min:1',
        ]);

        $this->draw_number = $validatedData['draw_number'];

        $this->getVenueId();
        $this->getPrizeId();

        $luck_draw = DB::select("CALL sp_lucky_draw('" . $this->venue_id . "', 'N')");
        $winner = [
            'dist_code'=> $luck_draw[0]->dist_code,
            'town_code'=> $luck_draw[0]->town_code,
            'account_no'=> $luck_draw[0]->account_no,
            'account_code'=> $luck_draw[0]->account_code,
            'consumer_name'=> $luck_draw[0]->consumer_name,
            'address'=> $luck_draw[0]->address,
            'is_lifeline'=> $luck_draw[0]->is_lifeline,
            'regname'=> $luck_draw[0]->regname,
            'regaddress'=> $luck_draw[0]->regaddress,
            'contact'=> $luck_draw[0]->contact,
            'winner'=> 'Y',
            'win_draw'=> $this->draw_number,
            'prize_id'=> $this->draw_prize_id,
        ];

        RaffleWinner::create($winner);

        $consumer = ConsumerData::find($luck_draw[0]->id)->update([
            'winner'=> 'Y',
            'win_draw'=> $this->draw_number,
        ]);

        $entries = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(39)->get()->pluck('raffle_entry')->toArray();
        // $winner = ConsumerData::where('winner', 'N')->inRandomOrder()->limit(1)->first();

        array_push($entries, ConsumerData::formatEntry($winner['account_no'], $winner['account_code'], $winner['consumer_name']));
        $this->dispatchBrowserEvent('onDraw', ['entries'=> $entries, 'winner'=> $winner]);

        $this->draw_number = $this->draw_number + 1;
    }



}
