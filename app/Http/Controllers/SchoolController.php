<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
         $schools = School::withCount('actors')->paginate(12);
    $cities = School::whereNotNull('city')->distinct()->pluck('city')->sort();
    
    return view('schools.index', compact('schools', 'cities'));
    }

    public function show(School $school)
{
    $school->loadCount('actors');
    $school->load(['actors.user', 'teacherActors.user']); 
    return view('schools.show', compact('school'));
}
}