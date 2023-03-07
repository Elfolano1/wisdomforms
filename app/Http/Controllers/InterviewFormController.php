<?php

namespace App\Http\Controllers;

use App\Models\InterviewForm;
use App\Http\Requests\InterviewFormRequest;
use App\Http\Resources\InterviewFormListResource;
use App\Http\Resources\InterviewFormResource;
use App\Events\VerificationCodeEvent;
use App\Events\NewUserEvent;
use App\Models\Candidate;

class InterviewFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $perPage = request('per_page', 10);
            $search = request('search', '');
            $status= request('status', '');
           if($status==1){
            $query=InterviewForm::getsigned($perPage,$search );
            return InterviewFormListResource::collection($query);
           } 
           if($status==2){
            $query=InterviewForm::getpendingval($perPage,$search );
            return InterviewFormListResource::collection($query);
           } 
           if($status==3){
            $query=InterviewForm::getpendingsign($perPage,$search );
            return InterviewFormListResource::collection($query);
           } 
           
           if($status==0){
            $query=InterviewForm::getall($perPage,$search);
            return InterviewFormListResource::collection($query);     
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InterviewFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InterviewFormRequest $request)
    {
        //
        
        $data = $request->validated();
        // $data['created_by'] = $request->user()->id;
        // $data['updated_by'] = $request->user()->id;
        $user=['CandidateFirstName'=>$data['CandidateFirstName'],
        'CandidateLastName'=>$data['CandidateLastName'],
        'CandidateEmail'=>$data['CandidateEmail'],
        'CandidatePhone'=>$data['CandidatePhone']];
        $candidate=Candidate::create($user);

        $formdatas=['Date'=>$data['Date'],
        'Q_1'=>$data['Q_1'],
        'Q_2'=>$data['Q_2'],
        'Q_3'=>$data['Q_3'],
        'Q_4'=>$data['Q_4'],
        'Q_5'=>$data['Q_5'],
        'Q_6'=>$data['Q_6'],
        'Q_7'=>$data['Q_7'],
        'Q_8'=>$data['Q_8'],
        'Q_9'=>$data['Q_9'],
        'Q_10'=>$data['Q_10'],
        'Q_11'=>$data['Q_11'],
        'Q_12'=>$data['Q_12'],
        'Q_13'=>$data['Q_13'],
        'Q_14'=>$data['Q_14'],
        'Q_15'=>$data['Q_15'],
        'Q_16'=>$data['Q_16'],
        'Q_17'=>$data['Q_17'],
        'Q_18'=>$data['Q_18'],
        'Q_19'=>$data['Q_19'],
        'Q_20'=>$data['Q_20'],
        'signed'=>$data['signed'],
        'close_status'=>$data['close_status'],
        'send_status'=>$data['send_status'],
        'status'=>$data['status'],
        'user_id'=>$data['user_id'],
         'candidate_id'=>$candidate->id];
        
        $InterviewForm=InterviewForm::create($formdatas);
        

        //  event(new NewUserEvent($user));
        return new InterviewFormResource($InterviewForm);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InterviewForm  $interviewForm
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        //
        $InterviewForm=InterviewForm::where('id',$id)->first();

        return new InterviewFormResource($InterviewForm);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\InterviewFormRequest  $request
     * @param  \App\Models\InterviewForm  $interviewForm
     * @return \Illuminate\Http\Response
     */
    public function update(InterviewFormRequest $request,$id)
    {
        
        $data = $request->validated();
        // dd($data);
        
        $formdatas=['Date'=>$data['Date'],
        'Q_1'=>$data['Q_1'],
        'Q_2'=>$data['Q_2'],
        'Q_3'=>$data['Q_3'],
        'Q_4'=>$data['Q_4'],
        'Q_5'=>$data['Q_5'],
        'Q_6'=>$data['Q_6'],
        'Q_7'=>$data['Q_7'],
        'Q_8'=>$data['Q_8'],
        'Q_9'=>$data['Q_9'],
        'Q_10'=>$data['Q_10'],
        'Q_11'=>$data['Q_11'],
        'Q_12'=>$data['Q_12'],
        'Q_13'=>$data['Q_13'],
        'Q_14'=>$data['Q_14'],
        'Q_15'=>$data['Q_15'],
        'Q_16'=>$data['Q_16'],
        'Q_17'=>$data['Q_17'],
        'Q_18'=>$data['Q_18'],
        'Q_19'=>$data['Q_19'],
        'Q_20'=>$data['Q_20'],
        'signed'=>$data['signed'], 
    ];
        InterviewForm::where('id',$id)->update($formdatas);
        $InterviewForm=InterviewForm::where('id',$id)->first();
        $user=['CandidateFirstName'=>$data['CandidateFirstName'],
        'CandidateLastName'=>$data['CandidateLastName'],
        'CandidateEmail'=>$data['CandidateEmail'],
        'CandidatePhone'=>$data['CandidatePhone']];
        Candidate::where('id',$InterviewForm->candidate_id)->update($user);
        return new InterviewFormResource($InterviewForm);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InterviewForm  $interviewForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterviewForm $interviewForm)
    {
        //
    }
    public function validateinterviewform(InterviewFormRequest $request,$id){
        InterviewForm::where('id',$id)->update(['close_status'=>1]);
        return response()->json(['status'=>1]);

    }
    public function convertTocaregiver($id){
        InterviewForm::where('id',$id)->update(['send_status'=>1]);
        $InterviewForm=InterviewForm::where('id',$id)->first(); 
        return new InterviewFormResource($InterviewForm);
    }
    public function countinterviewform(){
        $countAll=InterviewForm::where('send_status',0)->count();
        $countSigned=InterviewForm::where('signed',1)->where('close_status',1)->where('send_status',0)->count();
        $countPendingValidation=InterviewForm::where('signed',1)->where('close_status',0)->count();
        $countPendingSignature=InterviewForm::where('signed',0)->where('close_status',0)->count();
        return response()->json(['countAll'=>$countAll,'countSigned'=>$countSigned,'countPendingValidation'=>$countPendingValidation,'countPendingSignature'=>$countPendingSignature]);
    }
}
