<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job_Role;
use App\Models\Event_Type;
use App\Models\Person;
use App\Models\Person_Event_Action;

class PersonController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id = null)
    {
        $roles = Job_Role::all();
        $event_types = Event_Type::all();

        if ($id) {
            $person = Person::with('event_actions')->find($id);
            return view('add_person', ["person" => json_encode($person), "roles" => json_encode($roles), "event_types" => json_encode($event_types)]);
        } else {
            return view('add_person', ["roles" => json_encode($roles), "event_types" => json_encode($event_types)]);
        }
    }

    public function addPerson(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:persons,email',
            'job_role' => 'required'
        ]);

        if ($request->event_actions && count($request->event_actions) > 0) {
            foreach($request->event_actions as $action) {
                if (!$action['event_type_id'] || !$action['giphy_action'] || !$action['youtube_url']) {
                    return response()->json(['errors' => ['event_actions' => ['Youtube URL, Giphy URL, and Action Type are required fields']]], 422);
                }
            }
        }

        $person = Person::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'job_role_id' => $request->job_role
        ]);

        if ($request->event_actions && count($request->event_actions) > 0) {
            foreach($request->event_actions as $action) {
                $event_action = Person_Event_Action::create([
                    'person_id' => $person->id,
                    'event_type_id' => $action['event_type_id'],
                    'giphy_action' => $action['giphy_action'],
                    'youtube_url' => $action['youtube_url'],
                    'description' => $action['description']
                ]);
            }
        }

        return $this->success($person);
    }

    public function deletePerson(Request $request) {
        $validatedData = $request->validate([
            'person_id' => 'required'
        ]);

        $person = Person::find($request->person_id);

        $person->delete();

        return $this->success();
    }
}