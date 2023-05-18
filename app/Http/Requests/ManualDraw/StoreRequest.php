<?php

namespace App\Http\Requests\ManualDraw;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

use App\Models\RaffleWinnerManual;
use App\Models\RaffleWinner;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'venue_id' => 'required|string|max:3',
            'prize_id' => 'required|integer',
            'account_code' => [
                'required',
                'string',
                'max:15',
                Rule::unique(RaffleWinnerManual::class),
                Rule::unique(RaffleWinner::class),
            ],
            'consumer_name' => [
                'required',
                'string',
                'max:150',
                Rule::unique(RaffleWinnerManual::class),
            ],
            'address' => 'required|string|max:150',
            'contact' => [
                'required',
                'string',
                'max:20',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if($this->wantsJson())
        {
            $response = response()->json([
                'success' => false,
                'message' => 'Ops! Some errors occurred',
                'errors' => $validator->errors()
            ]);
        }else{
            $response = redirect()->route('manual-draw.create')
                ->with('message', 'Ops! Some errors occurred')
                ->withErrors($validator)
                ->withInput();
        }

        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }

    /**
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'account_code.unique' => 'Account Number is already tagged as winner.',
            'consumer_name.unique' => 'Name is already tagged as winner.',
        ];
    }


    // public function filters()
    // {
    //     return [
    //         'email' => 'trim|lowercase',
    //         'name' => 'trim|capitalize|escape'
    //     ];
    // }
}
