<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminSigninRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'otp' => ['required', 'digits:4'],  // L'OTP doit être exactement 4 chiffres
            'password' => [
                'required',       // Le mot de passe est requis
                'min:8',          // Longueur minimale de 8 caractères
                //'regex:/[A-Z]/',  // Doit contenir au moins une lettre majuscule
                //'regex:/[a-z]/',  // Doit contenir au moins une lettre minuscule
                //'regex:/[0-9]/',  // Doit contenir au moins un chiffre
                //'regex:/[@$!%*?&#]/'  // Doit contenir au moins un caractère spécial
            ],
        ];

    }
}
