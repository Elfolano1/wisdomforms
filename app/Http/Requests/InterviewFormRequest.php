<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterviewFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'CandidateFirstName'=>['nullable'],
            'CandidateLastName'=>['nullable'],
            'CandidateEmail'=>['nullable'],
            'CandidatePhone'=>['nullable'],
            'id'=>['nullable'],
            'Date'=>['nullable'],
            'Q_1'=>['nullable'],
            'Q_2'=>['nullable'],
            'Q_3'=>['nullable'],
            'Q_4'=>['nullable'],
            'Q_5'=>['nullable'],
            'Q_6'=>['nullable'],
            'Q_7'=>['nullable'],
            'Q_8'=>['nullable'],
            'Q_9'=>['nullable'],
            'Q_10'=>['nullable'],
            'Q_11'=>['nullable'],
            'Q_12'=>['nullable'],
            'Q_13'=>['nullable'],
            'Q_14'=>['nullable'],
            'Q_15'=>['nullable'],
            'Q_16'=>['nullable'],
            'Q_17'=>['nullable'],
            'Q_18'=>['nullable'],
            'Q_19'=>['nullable'],
            'Q_20'=>['nullable'],
            'signed'=>['nullable'],
            'close_status'=>['nullable'],
            'send_status'=>['nullable'],
            'status'=>['nullable'],
            'user_id'=>['nullable'],
            'candidate_id'=>['nullable'],
        ];
    }
}
