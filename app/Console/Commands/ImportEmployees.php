<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Employee;
use League\Csv\Reader;

class ImportEmployees extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:employees';
    protected $description = 'Import employee data from CSV file';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csv = Reader::createFromPath(storage_path('app/merged_dataframe.csv'), 'r');
        $csv->setHeaderOffset(0); // Assume first row is the header

        foreach ($csv as $record) {
            Employee::updateOrCreate(
                ['sid' => $record['sid']],
                [
                    'full_name' => $record['full_name'],
                    'gender' => $record['gender'],
                    'jobtitle' => $record['jobtitle'],
                    'division' => $record['division'],
                    'email' => $record['email'],
                ]
            );
        }

        $this->info('Employee data imported successfully!');
    }
}
