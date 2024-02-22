<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index()
    {
        $categories=Category::where('status',1)->orderBy('name','ASC')->take(8)->get();
        $featuredJobs=Job::where('status',1)
            ->orderBy('created_at','DESC')
            ->with('jobType')
            ->where('isFeatured',1)
            ->take(6)
            ->get();
        $latestjobs=Job::where('status',1)->orderBy('created_at','DESC')->take(6)->get();
        return view('fronts.home',[
           'categories'=>$categories,
            'featuredJobs'=>$featuredJobs,
            'latestjobs'=>$latestjobs,
        ]);
    }
}
