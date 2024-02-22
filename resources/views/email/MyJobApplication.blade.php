<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>CareerVibe | Find Best Jobs</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}" />
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
        <div class="container">
            <a class="navbar-brand" href="index.html">CareerVibe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href={{route('account.Profile')}}>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href=>Find Jobs</a>
                    </li>
                </ul>
                <a class="btn btn-outline-primary me-2" href={{route('account.Logout')}} type="submit">Logout</a>
                {{--<a class="btn btn-primary" href="post-job.html" type="submit">Post a Job</a>--}}
            </div>
        </div>
    </nav>
</header>
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href={{route('account.Profile')}}>Home</a></li>
                        <li class="breadcrumb-item active">My Jobs</li>
                    </ol>

                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card border-0 shadow mb-4 p-3">
                </div>
                <div class="card account-nav border-0 shadow mb-4 mb-lg-0">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item d-flex justify-content-between p-3">
                                <a href="account.html">Account Settings</a>
                            </li>
                            {{--<li class="list-group-item d-flex justify-content-between align-items-center p-3">--}}
                                {{--<a href={{route('account.CreateJob')}}>Post a Job</a>--}}
                            {{--</li>--}}
                            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <a href="my-jobs.html">My Jobs</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Applied Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href={{route('account.CreateJob')}} class="btn btn-primary">Post a Job</a>
                            </div>
                            <div>
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Job Created</th>
                                    <th scope="col">Applicants</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                @foreach($joobs as $JobApplications)
                                    <tbody class="border-0">
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{$JobApplications->job->title}}</div>
                                            <div class="info1">{{$JobApplications->job->jobType->name}}.{{$JobApplications->job->company_location}}</div>
                                        </td>
                                        <td>{{$JobApplications->created_at->diffForHumans()}}</td>
                                        <td>130 Applications</td>
                                        <td>
                                            @if($job->status == 1)
                                                <div class="job-status text-capitalize">active</div>
                                            @else()
                                                <div class="job-status text-capitalize">Block</div>
                                            @endif()
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{route('Job.Detail',$JobApplications->job->id)}}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                                                                    <li><a class="dropdown-item" href={{route('account.EditJob',$job->id)}}><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href={{route('account.DeleteJob',$JobApplications->job->id)}} onclick="deletejob({{$job->id}})"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="image"  name="image">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary mx-3">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark py-3 bg-2">
    <div class="container">
        <p class="text-center text-white pt-3 fw-bold fs-6">© 2023 xyz company, all right reserved</p>
    </div>
</footer>
<script type="text/javascript">
    function deletejob(jobid) {
        if(confirm("Are you sure you want to delete this Job")){

        }
        else{
            alert("Then Stay on this Page")
        }
    }
</script>
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.5.1.3.min.js')}}"></script>
<script src="{{asset('assets/js/instantpages.5.1.0.min.js')}}"></script>
<script src="{{asset('assets/js/lazyload.17.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/slick.min.js')}}"></script>
<script src="{{asset('assets/js/lightbox.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
</body>
</html>