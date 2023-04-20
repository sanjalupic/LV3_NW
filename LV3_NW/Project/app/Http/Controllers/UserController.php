<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//import models
use App\Models\User;
use App\Models\Project_User;
use App\Models\Project;

class UserController extends Controller
{
    function index(){
        //get all project ids where current user is member
        $projectIds = Project_User::whereJsonContains('team_members_id',  strval(auth()->user()->id))->get();
         //get all project ids where current user is manager
        $projectsWhereUserIsManager = Project::where('voditelj_id','=',strval(auth()->user()->id))->get();
        
        $projects= array();
        //for each fetched id get project data and store it in array
        foreach ($projectIds as $id) {
            $projects[] = Project::find($id->project_id);
          }
          //return a view with projects data
        return view('users.index',['user'=>auth()->user(),'projects'=>$projects, 'myProjects'=>$projectsWhereUserIsManager]);
    }

}
