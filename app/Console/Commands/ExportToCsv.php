<?php

namespace App\Console\Commands;

use App\maguttiCms\Exports\AdminListExporter;
use App\maguttiCms\Tools\ExportListHelper;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\maguttiCms\Exports\CollectionExport;

/**
 * Command per esportare un model della admin list
 * report è il nome del model
 *
 * Class ExportToCsv
 * @package App\Console\Commands
 */
class ExportToCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     *
     */
    protected $signature = 'export:csv {report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export a model from  admin list to csv';

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
        $model = $this->argument('report');
        $this->info('Start Exporting > '.$model);
        ini_set('memory_limit', '2048M');
        $ExportHelper = new AdminListExporter($model);
        $ExportHelper->setExtension('csv')->storeData();
        $memory = number_format(memory_get_peak_usage(true) / 1048576, 2) . ' MB';
        $this->info($memory);
        $this->info('File created'.$ExportHelper->fileStorage());
    }
}
