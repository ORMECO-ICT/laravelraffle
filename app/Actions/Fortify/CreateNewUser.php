<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\Rule;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $auth_keys = ['@gma41!', 'verify!', 'viewer!', '0jt'];
        Validator::make($input, [
            'username' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'auth_key' => ['required', 'string', 'max:20', 'in:'.implode(",", $auth_keys)],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $role = '';
        if ($input['auth_key'] == '@gma41!')
        $role='admin';
        elseif ($input['auth_key'] == 'verify')
        $role='verify';
        elseif ($input['auth_key'] == 'viewer')
        $role='user';
        elseif ($input['auth_key'] == '0jt')
        $role='verify';

        $user = User::create([
            'username' => $input['username'],
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => $role,
            'password' => Hash::make($input['password']),
        ]);

        return $user;
    }
}
