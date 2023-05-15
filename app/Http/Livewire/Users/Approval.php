<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class Approval extends Component
{
    public $user;

    public $showModal;

    public function mount($user)
    {
        $this->user = $user;
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.users.approval');
    }

    public function approve($id){
        $validatedData = $this->validate([
            'user.id' => 'required',
        ]);
        $user = User::find($id);
        if(\Auth::user()->id == $id){
            \Session::flash('status', 'Unable to modify approval of your own account.');
        }else{
            $user->is_approved = 'Y';
            $user->update();

            \Session::flash('status', 'Successfully approved registration of '. $user->name);

            $this->dispatchBrowserEvent('onSuccess');
            $this->showModal = false;
        }
    }

    public function disapprove($id){
        $validatedData = $this->validate([
            'user.id' => 'required',
        ]);
        $user = User::find($id);
        if(\Auth::user()->id == $id){
            \Session::flash('status', 'Unable to modify approval of your own account.');
        }else{
            $user->is_approved = 'N';
            $user->update();

            \Session::flash('status', 'Successfully disapproved registration of '. $user->name);

            $this->dispatchBrowserEvent('onSuccess');
            $this->showModal = false;
        }
    }
}
