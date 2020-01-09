<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use AlbertCht\Lumen\Testing\TestCase as TestCase;

class DaysBetweenDatetimesTest extends TestCase
{
    /**
     * @dataProvider validParameterProvider
     * @return void
     */
    public function testValidRequests($startDateTime, $endDateTime, $outputUnit, $expectedResult)
    {
        /** @var $response */
        $this->json('POST', '/api/days-between-dates', [
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
            ['2019-1-1 00:00:00', '2019-1-31 00:00:00', 'default', '30'],
            ['2019-1-2 00:00:00', '2019-1-31 00:00:00', '', '29'],
            ['2019-1-1 15:00:01', '2019-1-31 02:00:00', 'default', '29'],
            ['2019-6-1', '2019-5-31', 'default', '-1'],
            ['2019-6-1', '2019-5-31 EST', 'default', '0'],
            ['2019-1-1', '2019-1-2', 'default', '1'],
            ['2019-1-1', '2019-1-1', 'seconds', '0'],
            ['2019-1-1', '2019-1-2', 'seconds', '86400'],
            ['2019-1-1', '2019-1-5', 'seconds', '345600'],
            ['2019-2-1', '2019-2-10', 'minutes', '12960'],
            ['2019-2-1', '2019-2-8', 'hours', '168'],
            ['2019-2-1', '2019-3-1', 'years', '0.076660'],
            ['2020-2-1', '2020-3-1', 'years', '0.079398'], // leap year
        ];
    }

    /**
     * @dataProvider invalidParameterProvider
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
            ['', '', '', ['startDateTime', 'endDateTime']],
        ];
    }
}
