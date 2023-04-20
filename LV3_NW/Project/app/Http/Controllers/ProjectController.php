<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//import models
use App\Models\Project;
use App\Models\User;
use App\Models\Project_User;


class ProjectController extends Controller
{
    ///use auth middleware to protect routes
    public function __construct(){
        $this->middleware('auth');
    }
    public function create(){
        $users=User::where('id','!=',auth()->user()->id)->get();
        return view('projects.create',['users'=>$users]);
    }

    public function save(Request $request){
        ///fetching all data sent from form
        $project = new Project();
        $project->naziv_projekta = $request->naziv_projekta;
        $project->opis_projekta = $request->opis_projekta;
        $project->cijena_projekta = $request->cijena_projekta;
        $project->obavljeni_poslovi = $request->obavljeni_poslovi;
        $project->datum_pocetka = $request->datum_pocetka;
        $project->datum_zavrsetka = $request->datum_zavrsetka;
        ///getting current user ID, he is the manager
        $project->voditelj_id = auth()->user()->id;
        ///save project to database
        $project->save();
        ///get latest project id from database (the one we just saved)
        $latestProjectId = Project::all()->last()->id;
        $project_user = new Project_User();
        //setting and saving project and id's of team members
        $project_user->team_members_id = $request->team_members;
        $project_user->project_id = $latestProjectId;
        $project_user->save();

        return redirect('/');
    }
    public function getProject($id){
        $project = Project::find($id);
        return view('projects.updateProject',['project'=> $project]);
    }

    public function update(Request $request){
        error_log($request->id);
        $project = Project::find($request->id);
        if ($project->voditelj_id == auth()->user()->id) {
         $project->naziv_projekta = $request->naziv_projekta;
        $project->opis_projekta = $request->opis_projekta;
        $project->cijena_projekta = $request->cijena_projekta;
        $project->datum_pocetka = $request->datum_pocetka;
        $project->datum_zavrsetka = $request->datum_zavrsetka;
        }
        error_log('here');
        $project->obavljeni_poslovi = $request->obavljeni_poslovi;
        error_log($project->obavljeni_poslovi);
        $project->save();
        return redirect('/user');
    }
}
