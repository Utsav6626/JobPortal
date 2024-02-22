<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ClientController extends Controller
{
    public function Register(){
        return view('fronts.Client.Register');
    }

    public function RegisterProcessing(Request $request){
        $client=new Client();
        $client->name=$request->name;
        $client->email=$request->email;
        $client->password=Hash::make($request->name);
        $client->save();

        return redirect()->route('Client.Login')->with('success','You Have Registered Successfully Now Login with emai and password');
    }

    public function Login(){
        return view('fronts.Client.login');
    }

    public function LoginProcess(Request $request){
        if (Auth::guard('cp')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('Client.Home')->with('success', 'Login Successfully ');
        }
        return redirect()->route('Client.Login')->with('error', 'Not Authorised with Us ');
    }

    public function Home(){
//        return view('fronts.Client.Home');
        $categories=Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
        $featuredJobs=Job::where('status',1)
            ->orderBy('created_at','DESC')
            ->with('jobType')
            ->where('isFeatured',1)
            ->take(6)
            ->get();
        $id=Auth::user()->id;
        $client=Client::where('id',$id)->first();
//        dd($client);
        $latestjobs=Job::where('status',1)->orderBy('created_at','DESC')->take(6)->get();
        return view('fronts.Client.Home',[
            'categories'=>$categories,
            'featuredJobs'=>$featuredJobs,
            'latestjobs'=>$latestjobs,
            'client'=>$client,
        ]);
    }

    public function AccountView(){
        $id=Auth::user()->id;
        $Client=Client::where('id',$id)->first();
        return view('fronts.Client.Account',[
            'Client'=>$Client,
        ]);

    }

    public function UpdateProfile_Pic(Request $request){
        $user=Client::find(Auth::user()->id);
        if($request->hasFile('image')){
            $image=$request->file('image');
            $extension=$image->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $image->move('profile_pic/thumb/',$filename);
//            Register::where('id',$id)->update(['image'=>$filename]);
            $user->image=$filename;
            $user->save();
        }else{
            return $request;
            $user->image ='';
        }
        $user->save();
        return redirect()->route('Client.AccountView')->with('success','Updated the Picture');
    }

    public function Update(Request $request){
        $user=Client::find(Auth::user()->id);
        $user->name=$request->name;
        $user->mobile=$request->mobile;
        $user->designation=$request->designation;
        $user->save();

        return redirect()->route('Client.AccountView')->with('success','Updated Successfully');
    }

    public function Detail($id){
        $job= Job::where([
            'id'=>$id,
            'status'=>1,
        ])->with(['jobType','category'])->first();
//dd($id);
        $id=Auth::user()->id;
        $Client=Client::where('id',$id)->first();
//        dd($Client)*/
        if($job==NULL){
            abort(404);
        }
        return view('fronts.Client.JobDetailbyClient',[
            'id'=>$id,
            'job'=>$job,
            'Client'=>$Client,
        ]);
    }
    public function Logout(){
        Session::flush();
        Auth::guard('cp')->logout();
        return redirect()->route('home');
    }
}
