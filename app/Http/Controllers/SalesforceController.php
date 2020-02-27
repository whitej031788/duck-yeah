<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Person_Event_Action;
use App\Models\Duck_Alert;
use App\Events\IncomingAlert;

class SalesforceController extends Controller
{
    public function oppWon(Request $request)
    {
        $event_code = 'opp_won';
        $event_code_id = 1;

        $person = Person::where('email', trim($request->user_email))->first();

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

        $message = $this->buildMessage($request->opp_name, $request->opp_amount, $person->first_name, $person->last_name);
        event(new IncomingAlert(new Duck_Alert($this->buildTestData($person_event_action, $person, $message))));
        return $this->success('alert triggered');
    }

    public function oppCreated(Request $request)
    {

    }

    private function buildMessage($oppName, $amount, $fname, $lname) {
        return $fname . ' ' . $lname . ' has won opportunity ' . $oppName . ' with an estimated GMV of $' . $this->getAmountAttribute($amount) . '!';
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

    private function getAmountAttribute($value) {
        return number_format(($value), 2, '.', ',');
    }
}