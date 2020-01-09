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
        $diffMethod = function (Carbon $startDate, $endDate) {
            return $startDate->diffInDays($endDate, false);
        };
        return $this->commonBetweenDatesHandler($request, $diffMethod, 'convertDaysToOutputUnits');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function weekdaysBetweenDates(Request $request)
    {
        $diffMethod = function (Carbon $startDate, Carbon $endDate) {
            return $startDate->diffInWeekdays($endDate, false);
        };
        return $this->commonBetweenDatesHandler($request, $diffMethod, 'convertDaysToOutputUnits');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function completeWeeksBetweenDates(Request $request)
    {
        // We will assume "complete weeks" means monday to sunday, and no partial weeks at the start or end
        $diffMethod = function (Carbon $startDate, Carbon $endDate) {

            if ($startDate->diffInDays($endDate) < 7) {
                return 0;
            }

            if (!$startDate->isMonday()) {
                $startDate = $startDate->modify('next monday');
            }

            if (!$endDate->isMonday()) {
                $endDate = $endDate->modify('previous monday');
            }

            return $startDate->diffInWeeks($endDate, false);
        };

        return $this->commonBetweenDatesHandler($request, $diffMethod, 'convertWeeksToOutputUnits');
    }


    /**
     * @param Request $request
     * @param callable $diffMethod
     * @param string $convertOutputMethodName
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     * @throws \Exception
     */
    public function commonBetweenDatesHandler(Request $request, callable $diffMethod, string $convertOutputMethodName)
    {
        $this->validate($request, $this->validationRules());

        $startDate = new Carbon($request->input('startDateTime'));
        $endDate   = new Carbon($request->input('endDateTime'));

        $diffInDays = $diffMethod($startDate, $endDate);

        $result = $this->$convertOutputMethodName($request->input('outputUnit'), $diffInDays);

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
                'not_in:0',
                function ($attribute, $value, $fail) {
                    $this->validateCarbonAcceptsDatetime($attribute, $value, $fail);
                },
            ],
            'endDateTime'   => [
                'required',
                'not_in:0',
                function ($attribute, $value, $fail) {
                    $this->validateCarbonAcceptsDatetime($attribute, $value, $fail);
                },
                'after_or_equal:startDateTime',
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
            $fail($attribute . ' is not a valid datetime string. Try using YYYY-MM-DD HH:MM:SS, with an optional timezone if needed.');
        }
        else {
            try {
                $carbon = new Carbon($value);
                if (!$carbon->isValid()) {
                    throw new \Exception('Invalid datetime string');
                }
            } catch (\Exception $e) {
                $fail($attribute . ' is not a valid datetime string. Try using YYYY-MM-DD HH:MM:SS, with an optional timezone if needed.');
            }
        }
    }

    /**
     * @param string $outputUnit
     * @param int $diffInDays
     * @return false|float|int
     */
    public function convertDaysToOutputUnits(string $outputUnit, int $diffInDays)
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

    /**
     * @param string $outputUnit
     * @param int $diffInWeeks
     * @return false|float|int
     */
    public function convertWeeksToOutputUnits(string $outputUnit, int $diffInWeeks)
    {
        if ($outputUnit === '' || $outputUnit === 'default') {
            return $diffInWeeks;
        }

        return $this->convertDaysToOutputUnits($outputUnit, $diffInWeeks * 7);
    }
}
