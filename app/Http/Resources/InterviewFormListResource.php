<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewFormListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'CandidateFirstName'=>$this->candidate->CandidateFirstName,
            'CandidateLastName'=>$this->candidate->CandidateLastName,
            'CandidateEmail'=>$this->candidate->CandidateEmail,
            'CandidatePhone'=>$this->candidate->CandidatePhone,
            'id'=>$this->id,
            'Date'=>$this->Date,
            'Q_1'=>$this->Q_1,
            'Q_2'=>$this->Q_2,
            'Q_3'=>$this->Q_3,
            'Q_4'=>$this->Q_4,
            'Q_5'=>$this->Q_5,
            'Q_6'=>$this->Q_6,
            'Q_7'=>$this->Q_7,
            'Q_8'=>$this->Q_8,
            'Q_9'=>$this->Q_9,
            'Q_10'=>$this->Q_10,
            'Q_11'=>$this->Q_11,
            'Q_12'=>$this->Q_12,
            'Q_13'=>$this->Q_13,
            'Q_14'=>$this->Q_14,
            'Q_15'=>$this->Q_15,
            'Q_16'=>$this->Q_16,
            'Q_17'=>$this->Q_17,
            'Q_18'=>$this->Q_18,
            'Q_19'=>$this->Q_19,
            'Q_20'=>$this->Q_20,
            'signed'=>$this->signed,
            'status'=>$this->status,
            'user_id'=>$this->user_id,
            'close_status'=>$this->close_status,
            'send_status'=>$this->send_status,
            'created_at' =>$this->created_at,
        ];
    }
}
