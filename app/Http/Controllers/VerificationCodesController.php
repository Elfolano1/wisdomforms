<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use App\Http\Requests\VerificationCodeRequest;
use App\Http\Requests\UpdateVerificationCodeRequest;
use Carbon\Carbon;
use App\Events\VerificationCodeEvent;
use App\Models\InterviewForm;


class VerificationCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $formdatas=[];
        event(new VerificationCodeEvent($formdatas));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\VerificationCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerificationCodeRequest $request)
    {
        //
        $date=carbon::now()->format('Y-m-d H:i:s');
        $d=strtotime($date.' - 10 minute');
        $Comp_date=date('Y-m-d H:i:s', $d);
        $data = $request->validated();
        $count=VerificationCode::where('table','interview_forms')
        ->where('code',$data['code'])->where('created_at','>',$Comp_date)
        ->count();
        // where('user_id',$data['user_id'])
        // ->
        $status=0;
        if($count>0){
            InterviewForm::where('id',$data['id'])->update(['signed'=>1]);
            $status=1;
        }
        return response()->json(['status'=>$status]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VerificationCode  $verificationCode
     * @return \Illuminate\Http\Response
     */
    public function show(VerificationCode $verificationCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVerificationCodeRequest  $request
     * @param  \App\Models\VerificationCode  $verificationCode
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVerificationCodeRequest $request, VerificationCode $verificationCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VerificationCode  $verificationCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(VerificationCode $verificationCode)
    {
        //
    }
}
