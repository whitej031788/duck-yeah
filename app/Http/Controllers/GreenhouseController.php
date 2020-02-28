<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Person_Event_Action;
use App\Models\Duck_Alert;
use App\Events\IncomingAlert;

class GreenhouseController extends Controller
{
    public function candHired(Request $request)
    {
        $event_code = 'cand_hired';
        $event_code_id = 4;

        \Log::info($request->payload);

        $person = Person::where('email', trim($request->payload['application']['candidate']['recruiter']['email']))->first();

        if (is_null($person)) {
            return $this->error('person does not exist');
        }

        $person_event_action = Person_Event_Action::where([
            ['event_type_id', '=', $event_code_id],
            ['person_id', '=', $person->id],
        ])->get()->first();

        if (is_null($person_event_action)) {
            return $this->error('action does not exist');
        }

        $message = $this->buildMessage($person->first_name, $person->last_name, $request->payload['application']['offer']['custom_fields']['full_legal_name']['value'], $request->payload['application']['offer']['custom_fields']['official_job_title']['value']);
        \Log::info($message);
        event(new IncomingAlert(new Duck_Alert($this->buildTestData($person_event_action, $person, $message))));
        return $this->success('alert triggered');
    }

    private function buildMessage($first, $last, $candfirst, $title) {
        return $first . ' ' . $last . ' has hired ' . $candfirst . ' for the role of ' . $title . '!';
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