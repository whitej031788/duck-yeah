<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Person_Event_Action;
use App\Models\Duck_Alert;
use App\Events\IncomingAlert;

class ProdpadController extends Controller
{
    public function prodShipped(Request $request)
    {
        /* Need to fush this out a bit more */
        $event_code = 'prod_shipped';
        $event_code_id = 3;

        $person_event_action = Person_Event_Action::all()->last();

        if (is_null($person_event_action)) {
            return $this->error('action does not exist');
        }

        $message = $this->buildMessage($request->title);
        event(new IncomingAlert(new Duck_Alert($this->buildTestData($person_event_action, $message))));
        return $this->success('alert triggered');
    }

    private function buildMessage($title) {
        return 'Team Rhapsody have pushed the ProdPad idea "' . $title . '" to development! Come and ask them about it, or check ProdPad for updates and deployments!';
    }

    private function buildTestData($action, $event_description) {
        $alert_data = [
            "giphy_url" => $action->giphy_url,
            "youtube_key" => $action->youtube_key,
            "youtube_start" => $action->youtube_start,
            "event_description" => $event_description
        ];

        return $alert_data;
    }
}