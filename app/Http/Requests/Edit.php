<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Edit extends FormRequest
{
    /**
     * Determine if the user is authorised to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::get();
        if ($user->type == 'event_organiser'){
            $eventId = $this->input('id');
            if (Event::find($eventId) == $user->id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
            'name'=>'required',
            'date'=>'required|date|after:today',
            'time'=>'required',
            'location'=>'reqired|max:255',
            'category'=> ['required', Rule::in('Sport', 'Culture', 'Other')]
        ];
        $images = count($this->input('images'));
        for ($i = 0; $i++; $i < $images){
            $rules['images.'. $i] = 'image|mimes:jpeg,bmp,png|max:2000';
        }
        
        return $rules;
    }
}