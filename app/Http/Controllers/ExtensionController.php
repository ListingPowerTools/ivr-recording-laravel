<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Agent;
use Services_Twilio_Twiml;

class ExtensionController extends Controller
{
    /**
     * Responds with a <Dial> to the caller's planet
     *
     * @return \Illuminate\Http\Response
     */
    public function showExtensionConnection(Request $request)
    {
        $selectedOption = $request->input('Digits');

        try {
            $numberToDial = $this->_getPlanetNumberForDigit($selectedOption);
            $response = new Services_Twilio_Twiml;
            $response->say(
                "You'll be connected shortly to your planet. " .
                $this->_thankYouMessage,
                ['voice' => 'Alice', 'language' => 'en-GB']
            );

            $dialCommand = $response->dial(
                ['action' => '',
                 'method' => 'POST']
            );
            $dialCommand->number($numberToDial, ['url' => '']);

            return $response;
        }
        catch (ModelNotFoundException $e){
            return redirect()->route('main-menu-redirect');
        }
    }

    private function _getPlanetNumberForDigit($digit)
    {
        $planetExtensions = [
            '2' => 'Brodo',
            '3' => 'Dagobah',
            '4' => 'Oober'
        ];
        $planetExtensionExists = isset($planetExtensions[$digit]);

        if ($planetExtensionExists) {
            $planetNumber = Agent::where(
                'extension', '=', $planetExtensions[$digit]
            )->firstOrFail()->phone_number;

            return $planetNumber;
        } else {
            throw new ModelNotFoundException;
        }
    }
}