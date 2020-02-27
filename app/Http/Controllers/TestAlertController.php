<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\IncomingAlert;
use App\Models\Duck_Alert;
use Illuminate\Support\Facades\URL;
use App\Models\Person;
use App\Models\Person_Event_Action;

class TestAlertController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $persons = Person::with('event_actions')->get();
        return view('test_alert', ["persons" => json_encode($persons)]);
    }

    public function testAlert(Request $request)
    {
        $person = Person::find($request->person_id);
        $person_event_action = Person_Event_Action::find($request->person_event_action_id);

        if ($person->id != $person_event_action->person_id) {
            return response()->json(['errors' => ['main_errors' => ['That action does not belong to that person']]], 422);
        } else {
            event(new IncomingAlert(new Duck_Alert($this->buildTestData($person_event_action, $person, "Jamie White has won Opp worth $100,000", URL::to('/')))));
            return $this->success();
        }
    }

    private function buildTestData($action, $person, $event_description) {
        $alert_data = [
            "giphy_url" => $action->giphy_url,
            "youtube_key" => $action->youtube_key,
            "youtube_start" => $action->youtube_start,
            "custom_description" => $action->description,
            "user_first_name" => $person->first_name,
            "user_last_name" => $person->last_name,
            "event_description" => $event_description
        ];

        return $alert_data;
    }
}