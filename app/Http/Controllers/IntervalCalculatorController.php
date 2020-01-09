<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class IntervalCalculatorController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function daysBetweenDates(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $startDate = new Carbon($request->input('startDateTime'));
        $endDate   = new Carbon($request->input('endDateTime'));

        $diffInDays = $startDate->diffInDays($endDate, false);

        $result = $this->convertOutputUnits($request->input('outputUnit'), $diffInDays);

        $response['result'] = $result;

        return response()->json($response);

    }

    /**
     * Shared validation rules for the 3 API endpoints
     *
     * @return array
     */
    public function validationRules()
    {
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
    public function validateCarbonAcceptsDatetime($attribute, $value, $fail)
    {
        if (Carbon::hasRelativeKeywords($value)) {
            $fail($attribute . ' is a relative datetime, only absolute datetimes are supported');
        }

        try {
            $carbon = new Carbon($value);
            if (!$carbon->isValid()) {
                throw new \Exception('Invalid datetime string');
            }
        } catch (\Exception $e) {
            $fail($attribute . ' is not a valid datetime string. Try using YYYY-MM-DD HH:MM:SS, with an optional timezone if needed');
        }
    }

    /**
     * @param string $outputUnit
     * @param int $diffInDays
     * @return false|float|int
     */
    public function convertOutputUnits(string $outputUnit, int $diffInDays)
    {
        switch ($outputUnit) {
            case "seconds":
                $result = $diffInDays * 24 * 60 * 60;
                break;

            case "minutes":
                $result = $diffInDays * 24 * 60;
                break;

            case "hours":
                $result = $diffInDays * 24;
                break;

            case "years":
                $result = round($diffInDays / 365.25, 6); // 100 000ths of a year seems enough
                break;

            case "default":
            default:
                $result = $diffInDays;
        }
        return $result;
    }
}
