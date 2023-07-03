<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Password extends Component
{
    public $user;

    public $password;
    public $password_confirmation;

    public $showModal;

    public function mount($user)
    {
        $this->user = $user;
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.users.password');
    }

    public function save($id){
        $validatedData = $this->validate([
            'user.id' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);
        $user = User::find($id);
        if(\Auth::user()->id == $id){
            \Session::flash('status', 'Unable to reset password of own account.');
        }else{
            if($this->password != $this->password_confirmation){
                \Session::flash('status', 'Confirm password not matched.');
            }else{
                $user->password = Hash::make($this->password);
                $user->update();

                \Session::flash('status', 'Successfully changed the password of '. $user->name);

                $this->dispatchBrowserEvent('onSuccess');
                $this->showModal = false;
            }
        }
    }
}
