<?php

namespace App\Rules;

use App\Models\Contact;
use Illuminate\Contracts\Validation\Rule;

class InvalidEmail implements Rule
{
    public $email;

    public function __construct($email = null)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value)
    {
        return Contact::where('user_id', auth()->id())
            ->whereHas('user', function ($query) use ($value) {
                $query->where('email', $value)
                ->when($this->email,function($query){
                    $query->where('email','!=',$this->email);
                });

            })->count() === 0;
    }

    public function message()
    {
        return 'El correo electronico ingresado ya se encuentra registrado.';
    }
}
