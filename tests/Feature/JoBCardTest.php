<?php

namespace Tests\Feature;

use Database\Seeders\JobCardSeeder;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class JoBCardTest extends TestCase
{
    use RefreshDatabase;

    protected $seeder = JobCardSeeder::class;

    public function test_job_analysis_report_return_accurate_data()
    {
        try {
            DB::reconnect();
        } catch (QueryException $exception) {
            echo $exception;
        }


        $response = $this->json('get', route('job_analysis'));

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll('jobsArray', 'jobCodes')
                ->has('jobsArray', 3, function (AssertableJson $json) {
                    $json->where('A.count', 2);
                    $json->where('A.amount', 110);
                })
                ->has('jobCodes', 2)
                ->etc();
        });

        $response->assertStatus(200);
    }
}
