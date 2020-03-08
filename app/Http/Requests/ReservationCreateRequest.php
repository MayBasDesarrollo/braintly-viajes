<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class ReservationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'flight_id' => ['present', 
                            Rule::exists('flights', 'id')
                        ],
            'name' => 'required',
            'email' => ['required', 'email'],
            'class' => 'required|in:0,1',
            'pricef' => 'present',
            'pricee' => 'present',
        ];
    }

    public function createReservation()
    {
        
        // DB::transaction(function () {

            $data = $this->validated();

            $reservation = new Reservation([
                'flight_id' => $data['flight_id'],
                'name' => $data['name'],
                'email' => $data['email'],
                'class' => $data['class'],
            ]);

            $reservation->price = $data['class'] ? $data['pricef'] : $data['pricee'];

            $reservation->save();
            
        // });
    }
}
