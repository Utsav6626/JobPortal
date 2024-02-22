<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function Registration(){
        return view('fronts.account.registration');
    }
    public function RegistrationProcessing(Request $request){
        $user=new Register();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->name);
        $user->save();

        return redirect()->route('Recruiter.Login')->with('success','You Have Registered Successfully');
    }


    public function Login(){
        return view('fronts.account.login');
    }

    
    public function ProfileView(Request $request){
        if (Auth::guard('pr')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.Profile')->with('success', 'Login Successfully ');
        }
        return redirect()->route('Recruiter.Login')->with('error', 'Not Authorised with Us ');
    
    }

    public function Profile(){
       $id= Auth::user()->id;
       $user=Register::where('id',$id)->first();
        return view('fronts.account.profile',[
            'user'=>$user
        ]);
    }

    public function Update(Request $request){
        $user=Register::find(Auth::user()->id);
        $user->name=$request->name;
        $user->mobile=$request->mobile;
        $user->designation=$request->designation;
        $user->save();

        return redirect()->route('account.Profile')->with('success','Updated Successfully');
    }





    public function Logout(){
       Session::flush();
       Auth::guard('pr')->logout();
       return redirect()->route('home');
    }

    public function PostJob(){
//        return view('fronts.account.postjob');
        $id= Auth::user()->id;
        $user=Register::where('id',$id)->first();
        return view('fronts.account.job.create',[
            'user'=>$user
        ]);
    }

    public function CreateJob(){
//      return view('fronts.account.job.create');
        $id= Auth::user()->id;
        $user=Register::where('id',$id)->first();
        $categories=Category::where('status',1)->get();
        $jobnatures=JobType::get();
        return view('fronts.account.job.create',[
            'user'=>$user,
            'categories'=>$categories,
            'jobnatures'=>$jobnatures
        ]);
    }

    public function SaveJob(Request $request){
        $job=new Job();
        $job->title=$request->title;
        $job->category_id =$request->category_id ;
        $job->job_type_id =$request->job_type_id ;
        $job->user_id =Auth::user()->id;
        $job->vacancy=$request->vacancy;
        $job->salary=$request->salary;
        $job->location=$request->location;
        $job->description=$request->description;
        $job->benefits=$request->benefits;
        $job->responsibility=$request->responsibility;
        $job->qualification=$request->qualification;
        $job->keywords=$request->keywords;
        $job->experience=$request->experience;
        $job->company_name=$request->company_name;
        $job->company_location=$request->company_location;
        $job->company_website=$request->company_website;
        $job->save();

        return redirect()->route('account.MyJob')->with('success','Job Added Successfully');
    }

    public function MyJob(){

        $id= Auth::user()->id;
        $jobs=Job::where('user_id',Auth::user()->id)->with('jobType')->paginate(10);
        return view('fronts.account.job.myjobs',[
            'jobs'=>$jobs,
        ]);
    }

    public function EditJob(Request $request, $id){
        $id= Auth::user()->id;
        $user=Register::where('id',$id)->first();
        $categories=Category::where('status',1)->get();
        $jobnatures=JobType::get();
        $job=Job::where([
            'user_id'=>Auth::user()->id,
            'id'=>$id
        ])->first();
//        if($job==null){
//            abort(404);
//        }
        return view('fronts.account.job.edit',[
            'categories'=>$categories,
            'jobnatures'=>$jobnatures,
            'user'=>$user,
            'job'=>$job,
        ]);
    }

    public function DeleteJob(Request $request){
            $job=Job::where([
                'user_id'=>Auth::user()->id,
                'id'=>$request->jobid,
            ])->first();

            if($job==null){
                return redirect()->route('account.MyJob')->with('error','Job not Found');
            }
            Job::where('id',$request->jobid)->delete();
            return redirect()->route('account.MyJob')->with('success','Job Deleted Successfully');
    }
}
