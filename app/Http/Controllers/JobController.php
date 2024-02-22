<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    public function Index(){
        $categories=Category::where('status',1)->get();
        $jobtypes=JobType::where('status',1)->get();
        $jobs=Job::where('status',1)->with('jobType')->orderBy('created_at','DESC')->paginate(9);
        return view('fronts.jobs',[
            'categories'=>$categories,
            'jobtypes'=>$jobtypes,
            'jobs'=>$jobs,
        ]);
    }

    public function Detail($id){
        $job= Job::where([
            'id'=>$id,
            'status'=>1,
        ])->with(['jobType','category'])->first();

        if($job==NULL){
            abort(404);
        }
        return view('fronts.account.job.JobDetail',[
            'id'=>$id,
            'job'=>$job,
        ]);
    }

    public function ApplyJob(Request $request){
        $id= $request->id;
        $job= Job::where(
            'id',$id)
        ->first();

        dd($id);
        if($job==null){
            return redirect()->route('account.MyJob')->with('error','Job Not Exists');
        }

        $employer_id=$job->user_id;
        if($employer_id==Auth::user()->id){
            return redirect()->route('account.MyJob')->with('error','You can not apply to your own job');
        }

        $application=new JobApplication();
        $application->job_id=$id;
        $application->user_id=Auth::user()->id;
        $application->employer_id=$employer_id;
        $application->applied_date=now();
        $application->save();

        $employer=Register::where('id',$employer_id)->first();

        $mailData=[
            'employer'=>$employer,
            'user'=>Auth::user(),
            'job'=>$job,
        ];

        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));
        return redirect()->route('Job.Detail')->with('success','You Have Applied for the Job');
    }

    public function MyJobApplications(){
        $joobs=JobApplication::where('user_id',Auth::user()->id)->with(['job','job.jobType'])->paginate(10);
        return view('email.MyJobApplication',[
            'joobs'=>$joobs
        ]);

    }
}
