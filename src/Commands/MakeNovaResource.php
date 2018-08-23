<?php

namespace Inani\NovaResourceMaker\Commands;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Inani\NovaResourceMaker\Helpers\Tagable;
use ReflectionClass;

class MakeNovaResource extends Command
{
    use Tagable;

    protected $fields = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nova-resource:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the array of fields';

    /**
     * Create a new command instance.
     *
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
        do{
            $model = $this->ask("What is the name of the Model?");

            if( !$this->checkIfModelExists($model)){
                $this->error("Model {$model} doesn't exist!");
                return;
            }
            // Get all fields
            $this->fields = $this->tagThem($this->getColumnList(new $model()));
            dd($this->fields);
                // foreach field try to propose options

            // Relationships?

        }while($this->confirm('Do you wish to continue?'));
    }

    /**
     * Check if the Model exists
     *
     * @param $model
     * @return bool
     */
    private function checkIfModelExists($model)
    {
         if( !class_exists($model)){
             return false;
         }

        $class = new ReflectionClass($model);
        if( !$class->isSubclassOf(Model::class)){
            return false;
        }

        return true;
    }

    /**
     * Get Column list
     *
     * @param $model
     * @return mixed
     */
    private function getColumnList($model){
        return $this->getColumnListing($model->getTable());
    }


    /**
     * Get Columns with types
     *
     * @param $table
     * @return array
     */
    protected function getColumnListing($table)
    {
        return DB::select(DB::raw('SHOW COLUMNS FROM '. $table));
    }
}
