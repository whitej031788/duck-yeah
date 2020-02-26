<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_Role;
use App\Models\Event_Type;
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = Job_Role::all();
        $event_types = Event_Type::all();
        return view('add_person', ["roles" => json_encode($roles), "event_types" => json_encode($event_types)]);
    }

    public function addPerson(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:persons,email',
            'job_role' => 'required'
        ]);

        $person = Person::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'job_role_id' => $request->job_role
        ]);

        return $this->success($person);
    }
}