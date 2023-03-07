<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable=['CandidateFirstName','CandidateLastName','CandidateEmail','CandidatePhone'];
    public function interview_forms(){
        return $this->hasMany('App\Models\InterviewForm','candidate_id','id');
    }
}
