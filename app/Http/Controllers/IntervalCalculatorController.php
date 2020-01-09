<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class IntervalCalculatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function daysBetweenDates(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $startDate = new Carbon( $request->input('startDateTime'));

        $out['startDate'] = $startDate->format('H:i:s Y/m/d');
        $out['startDate  TZ'] = $startDate->tzName;
        $out['startDate  UTC Offset'] = $startDate->utcOffset();

        return  response()->json($out);

    }

    /**
     * Shared validation rules for the 3 API endpoints
     *
     * @return array
     */
    private function validationRules() {
        return [
            'startDateTime' => [
                'required',
                function ($attribute, $value, $fail) {
                    $this->validateCarbonAcceptsDatetime($attribute, $value, $fail);
                },
            ],
            'endDateTime'   => [
                'required',
                function ($attribute, $value, $fail) {
                    $this->validateCarbonAcceptsDatetime($attribute, $value, $fail);
                },
            ],
            'outputUnit'    => 'in:default,seconds,minutes,hours,years',
        ];
    }

    /**
     * @param $attribute
     * @param $value
     * @param $fail
     */
    private function validateCarbonAcceptsDatetime($attribute, $value, $fail) {
        if( Carbon::hasRelativeKeywords($value)) {
            $fail($attribute . ' is a relative datetime, only absolute datetimes are supported');
        }

        try {
            $carbon = new Carbon($value);
            if (!$carbon->isValid()) {
                throw new \Exception('Invalid datetime string');
            }
        }
        catch(\Exception $e)
        {
            $fail($attribute . ' is not a valid datetime string. Try using YYYY-MM-DD HH:MM:SS, with an optional timezone if needed');
        }
    }
}
