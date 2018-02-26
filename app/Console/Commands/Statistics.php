<?php

namespace App\Console\Commands;

use App\Services\StatisticsService;
use Illuminate\Console\Command;

class Statistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:statistics {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date');
        if (isset($date) && !empty($date)) {
            StatisticsService::storage($date);
        } else {
            StatisticsService::storage();
        }
    }
}
