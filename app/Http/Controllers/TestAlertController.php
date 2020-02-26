<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\IncomingAlert;
use App\Models\Duck_Alert;
use Illuminate\Support\Facades\URL;

class TestAlertController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('test_alert');
    }

    public function testAlert(Request $request)
    {
        event(new IncomingAlert(new Duck_Alert($this->buildTestData(URL::to('/')))));

        return $this->success();
    }

    private function buildTestData($url) {
        echo $url;
        $alert_data = [
            "giphy_url" => "https://media.giphy.com/media/aFTt8wvDtqKCQ/giphy.gif",
            "youtube_url" => "http://www.youtube.com/embed/nZXRV4MezEw?start=35&autoplay=1&enablejsapi=1&origin=" . $url,
            "custom_description" => "Baller Yo",
            "user_first_name" => "Jamie",
            "user_last_name" => "White",
            "event_description" => "Jamie White has won Opp worth $100,000"
        ];

        return $alert_data;
    }
}