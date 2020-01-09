<?php

use AlbertCht\Lumen\Testing\TestCase as TestCase;

class CompleteWeeksBetweenDatetimesTest extends TestCase
{
    /**
     * @dataProvider validParameterProvider
     * @param $startDateTime
     * @param $endDateTime
     * @param $outputUnit
     * @param $expectedResult
     * @return void
     */
    public function testValidRequests($startDateTime, $endDateTime, $outputUnit, $expectedResult)
    {
        /** @var $response */
        $this->json('POST', '/api/complete-weeks-between-dates', [
            'startDateTime' => $startDateTime,
            'endDateTime'   => $endDateTime,
            'outputUnit'    => $outputUnit,
        ])
            ->assertJson(['result' => $expectedResult]);
    }

    /**
     * Data Provider for the testValidRequests method
     *
     * @return array
     */
    public function validParameterProvider()
    {
        return [
            // startDateTime, endDateTime, outputUnit, expected Result
            ['2020-1-1 00:00:00', '2020-1-31 00:00:00', 'default', '3'],
            ['2020-1-12 00:00:00', '2020-1-31 00:00:00', '', '2'],
            ['2019-1-1 15:00:01', '2019-1-31 02:00:00', 'default', '3'],
            ['2019-12-4', '2019-12-4', 'seconds', '0'],
            ['2019-12-4', '2019-12-16', 'seconds', '604800'],
            ['2019-12-1', '2019-12-18', 'seconds', '1209600'],
            ['2019-2-1', '2019-2-13', 'minutes', '10080'],
            ['2019-2-1', '2019-2-18', 'hours', '336'],
            ['2019-2-1', '2019-3-1', 'years', '0.057495'],
            ['2020-2-1', '2020-3-1', 'years', '0.057495'], // leap year


        ];
    }

    /**
     * @dataProvider invalidParameterProvider
     * @param $startDateTime
     * @param $endDateTime
     * @param $outputUnit
     * @param $expectedErrorFields
     * @return void
     */
    public function testInvalidRequests($startDateTime, $endDateTime, $outputUnit, $expectedErrorFields)
    {
        /** @var $response */
        $this->json('POST', '/api/days-between-dates', [
            'startDateTime' => $startDateTime,
            'endDateTime'   => $endDateTime,
            'outputUnit'    => $outputUnit,
        ])
            ->assertStatus(422) // unprocessable entity
            ->assertJsonStructure($expectedErrorFields);
    }

    /**
     * Data Provider for the testInvalidRequests method
     *
     * @return array
     */
    public function invalidParameterProvider()
    {
        return [
            // startDateTime, endDateTime, outputUnit, expected Result
            ['2019-1-1', 'not a date', 'default', ['endDateTime']],
            ['2019-6-4', '2019-6-3', 'default', ['endDateTime']],
            ['2019-6-4', '2019-5-3', 'default', ['endDateTime']],
            ['2019-6-4', '2019-6-3 EST', 'default', ['endDateTime']],
            ['', '', '', ['startDateTime', 'endDateTime']],
            ['2019-1-1', '2019-1-21', 'rainbow', ['outputUnit']],
        ];
    }
}
