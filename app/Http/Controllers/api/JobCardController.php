<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JobCard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class JobCardController extends Controller
{
    public function __invoke()
    {
        $jobs = JobCard::select([
            'job_comp_code',
            DB::raw("SUM(job_invoice_amount) as amount"),
            DB::raw("COUNT(job_comp_code) as count"),
            DB::raw("DATE_FORMAT(job_received_date, '%Y-%m') as date"),
        ])
            ->groupBy(
                'job_comp_code',
                'date',
            )
            ->orderBy('date')
            ->get();

        return $this->getReportMethod1($jobs);
    }

    private function getReportMethod2(Collection $jobs)
    {
        $jobsArray = [];

        $jobs->each(function ($job) use (&$jobsArray) {
            $jobCode = $job['job_comp_code'];
            $formatedDate = Carbon::parse($job->date)->format('Y F');
            $jobKey = $this->getJobKey($jobsArray, $formatedDate);
            if ($jobKey === -1) {
                $newJob = [
                    'date' => $formatedDate,
                    'job_amount_'.$jobCode => (int)$job['amount'],
                    'job_count_'.$jobCode => $job['count'],

                ];
                array_push($jobsArray, $newJob);
            } else {
                $jobsArray[$jobKey]['job_amount_'.$jobCode] = $job['amount'];
                $jobsArray[$jobKey]['job_count_'.$jobCode] = $job['count'];
            }
        });


        $jobCodes = $this->getCodes($jobs);

        return compact('jobsArray', 'jobCodes');
    }

    private function getJobKey(array $jobsArray, string $date): int
    {
        foreach ($jobsArray as $key => $job) {
            if ($job['date'] === $date) {
                return $key;
            }
        }

        return -1;
    }

    private function getReportMethod1(Collection $jobs)
    {
        $jobsArray = [];

        $jobs->each(function ($job) use (&$jobsArray) {
            $jobCode = $job['job_comp_code'];
            $formatedDate = Carbon::parse($job->date)->format('Y F');
            $jobsArray[$formatedDate][$job->job_comp_code] = [
                'count' => $job->count,
                'amount' => (int)$job->amount,
            ];
        });

        $jobCodes = $this->getCodes($jobs);

        return compact('jobsArray', 'jobCodes');
    }

    private function getCodes(Collection $jobs)
    {
        $jobCodes = $jobs
            ->pluck('job_comp_code')
            ->sortBy('job_comp_code')
            ->unique()
            ->values();

        return $jobCodes;
    }
}
