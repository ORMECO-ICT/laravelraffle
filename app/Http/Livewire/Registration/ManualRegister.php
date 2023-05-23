<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;
use App\Models\ManualRegistration;

class ManualRegister extends Component
{
    public $consumer;
    public $account_code, $consumer_name, $address, $regname, $contact, $venue_id;

    public $showModal;

    public function mount($consumer)
    {
        $this->consumer = $consumer;
        $this->venue_id = \Auth::user()->venue_id;

        $this->showModal = false;

        $this->account_code = trim($this->consumer->account_code);
        $this->consumer_name = trim($this->consumer->consumer_name);
        $this->address = trim($this->consumer->address);
        $this->regname = trim($this->consumer->consumer_name);
    }

    public function render()
    {

        return view('livewire.registration.manual-register');
    }

    public function register($account_no){
        $validatedData = $this->validate([
            'venue_id' => 'required|max:3',
            'account_code' => 'required|max:15',
            'consumer_name' => 'required|max:250',
            'address' => 'required|max:150',
            'regname' => 'required|max:250',
            'contact' => 'max:11',
        ]);
        // dd($validatedData);
        $reg = ManualRegistration::with('venue')->select('*')->where('account_no',$account_no)->first();
        if ($reg){
            \Session::flash('status', 'Account is already registered in ' . $reg->venue->venue_name);
        }else{
            $validatedData['account_no'] = $account_no;
            $validatedData['user_id'] = \Auth::user()->id;

            $consumer = ManualRegistration::create($validatedData);
            \Session::flash('status', 'Successfully saved registration of '. $consumer->name);

            $this->dispatchBrowserEvent('onSuccess');
            $this->showModal = false;
        }
    }
}
