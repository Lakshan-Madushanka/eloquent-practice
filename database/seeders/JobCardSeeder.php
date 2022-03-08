<?php

namespace Database\Seeders;

use App\Models\JobCard;
use Illuminate\Database\Seeder;

class JobCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobRecords = collect([
            ['A', 101, '2020-06-15', '2020-06-15', 50, 'Invoiced'],
            ['A', 102, '2020-06-15', '2020-06-15', 60, 'Invoiced'],
            ['A', 103, '2020-07-20', '2020-07-20', 50, 'Invoiced'],
            ['A', 104, '2020-08-25', '2020-08-25', 45, 'Invoiced'],
            ['A', 105, '2020-08-17', '2020-08-17', 55, 'Invoiced'],
            ['A', 106, '2020-08-17', null, null, 'Received'],
            ['B', 201, '2020-07-15', '2020-07-15', 45, 'Invoiced'],
            ['B', 202, '2020-07-16', '2020-07-16', 35, 'Invoiced'],
            ['B', 203, '2020-08-17', '2020-08-17', 50, 'Invoiced'],
            ['B', 207, '2020-08-17', null, 50, 'Received'],
        ]);

        $jobRecords->each(function ($record) {
            JobCard::create([
                'job_comp_code' => $record[0],
                'job_enq_no' => $record[1],
                'job_received_date' => $record[2],
                'job_invoice_date' => $record[3],
                'job_invoice_amount' => $record[4],
                'job_status' => $record[5],
            ]);
        });
    }
}
