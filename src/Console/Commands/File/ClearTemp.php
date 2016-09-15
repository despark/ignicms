<?php

namespace Despark\Cms\Console\Commands\File;

use Carbon\Carbon;
use Despark\Cms\Models\File\Temp;
use Illuminate\Console\Command;
use DB;

/**
 * Class ClearTemp.
 */
class ClearTemp extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'igni:file:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans any temp leftovers.';

    /**
     * @var Temp
     */
    protected $tempModel;

    /**
     * ClearTemp constructor.
     * @param Temp $tempModel
     */
    public function __construct(Temp $tempModel)
    {
        parent::__construct();
        $this->tempModel = $tempModel;
    }

    /**
     * Run command.
     */
    public function handle()
    {
        $deleteBefore = Carbon::now()->subWeek();
        $filesToDelete = $this->tempModel->where('created_at', '<=', $deleteBefore)->get();
        $failed = [];

        foreach ($filesToDelete as $file) {
            // delete the file
            if (! \File::delete($file->getTempPath())) {
                $this->output->warning(sprintf('%s file not found. Skipping...', $file->getTempPath()));
            }
        }

        $deletedRecords = DB::table($this->tempModel->getTable())
                            ->where('created_at', '<=', $deleteBefore)
                            ->delete();

        $this->output->success(sprintf('%d temp file cleaned', $deletedRecords));
    }
}
