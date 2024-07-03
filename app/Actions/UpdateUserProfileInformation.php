<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ])->validate();

        if ($input['email'] !== $user->email) {
            $user->forceFill([
                'email' => $input['email'],
            ])->save();
        }

        $user->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}
