<?php

namespace App\Http\Livewire\Registration;

use Livewire\Component;
use App\Models\ManualRegistration;


class ManualActions extends Component
{
    public $consumer;
    public $account_code, $consumer_name, $address, $regname, $contact, $venue_id;

    public $showModal;

    public function mount($consumer)
    {
        $this->consumer = $consumer;
        $this->showModal = false;

        $this->account_code = trim($this->consumer->account_code);
        $this->consumer_name = trim($this->consumer->consumer_name);
        $this->address = trim($this->consumer->address);
        $this->regname = trim($this->consumer->regname);
        $this->contact = trim($this->consumer->contact);
        $this->venue_id = trim($this->consumer->venue_id);
    }

    public function render()
    {
        return view('livewire.registration.manual-actions');
    }

    public function update($account_no){
        $validatedData = $this->validate([
            'venue_id' => 'required|max:3',
            'account_code' => 'required|max:15',
            'consumer_name' => 'required|max:250',
            'address' => 'required|max:150',
            'regname' => 'required|max:250',
            'contact' => 'max:11',
        ]);
        // dd($validatedData);
        $reg = ManualRegistration::select('*')->where('account_no',$account_no)->first();
        if (!$reg){
            \Session::flash('status', 'Record could not be found!');
        }else{
            $reg->user_id =  \Auth::user()->id;
            $reg->venue_id =  $validatedData['venue_id'];
            $reg->regname =  $validatedData['regname'];
            $reg->contact =  $validatedData['contact'];
            $reg->update();

            \Session::flash('status', 'Successfully updated registration of '. $reg->name);

            $this->dispatchBrowserEvent('onSuccess');
            $this->showModal = false;
        }
    }

    public function delete($account_no){
        $reg = ManualRegistration::select('*')->where('account_no',$account_no)->first();
        if (!$reg){
            \Session::flash('status', 'Record could not be found!');
        }else{
            $reg->delete();

            \Session::flash('status', 'Successfully deleted registration of '. $reg->name);

            $this->dispatchBrowserEvent('onSuccess');
            $this->showModal = false;
        }
    }
}
