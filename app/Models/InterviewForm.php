<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewForm extends Model
{
    use HasFactory;
    protected $fillable=['Date','Q_1','Q_2','Q_3','Q_4','Q_5','Q_6','Q_7','Q_8','Q_9','Q_10',
    'Q_11','Q_12','Q_13','Q_14','Q_15','Q_16','Q_17','Q_18','Q_19','Q_20','signed',
    'close_status','send_status','status','user_id','candidate_id'];

    public function candidate(){
        return $this->belongsTo('App\Models\Candidate','candidate_id');
    }
    public static function getall($perPage,$search){
        $query = InterviewForm::query()
        ->with('candidate')
        ->where('send_status','=',0)
            ->orderBy('created_at','desc')
            ->WhereHas('candidate', function ($query) use ($search) {
                $query->where('CandidateFirstName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateLastName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateEmail', 'like', '%'.$search.'%')
                       ->orwhere('CandidatePhone', 'like', '%'.$search.'%')
                       ;
            })
            ->paginate($perPage);
            return $query;
    }
    public static function getsigned($perPage,$search){
        $query = InterviewForm::query()
        ->with('candidate')
        ->where('signed',1)
        ->where('close_status',1)
        ->where('send_status','=',0)
            ->orderBy('created_at','desc')
            ->WhereHas('candidate', function ($query) use ($search) {
                $query->where('CandidateFirstName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateLastName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateEmail', 'like', '%'.$search.'%')
                       ->orwhere('CandidatePhone', 'like', '%'.$search.'%')
                       ;
            })
            ->paginate($perPage);
            return $query;
    }
    public static function getpendingval($perPage,$search){
        $query = InterviewForm::query()
        ->with('candidate')
        ->where('signed',1)
        ->where('close_status',0)
        ->where('send_status','=',0)
            ->orderBy('created_at','desc')
            ->WhereHas('candidate', function ($query) use ($search) {
                $query->where('CandidateFirstName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateLastName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateEmail', 'like', '%'.$search.'%')
                       ->orwhere('CandidatePhone', 'like', '%'.$search.'%')
                       ;
            })
            ->paginate($perPage);
            return $query;
    }
    public static function getpendingsign($perPage,$search){
        $query = InterviewForm::query()
        ->with('candidate')
        ->where('signed',0)
        ->where('close_status',0)
        ->where('send_status','=',0)
            ->orderBy('created_at','desc')
            ->WhereHas('candidate', function ($query) use ($search) {
                $query->where('CandidateFirstName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateLastName', 'like', '%'.$search.'%')
                       ->orwhere('CandidateEmail', 'like', '%'.$search.'%')
                       ->orwhere('CandidatePhone', 'like', '%'.$search.'%')
                       ;
            })
            ->paginate($perPage);
            return $query;
    }
}
