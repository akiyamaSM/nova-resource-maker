<?php

namespace Inani\NovaResourceMaker\Commands;

use Inani\NovaResourceMaker\Helpers\FieldsBuilder;
use Inani\NovaResourceMaker\Helpers\Tagable;
use Inani\NovaResourceMaker\Helpers\Querable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\Command;
use ReflectionClass;

class MakeNovaResource extends Command
{
    use Tagable,
        Querable;

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
    protected $builder;

    /**
     * Create a new command instance.
     * @param FieldsBuilder $builder
     */
    public function __construct(FieldsBuilder $builder)
    {
        parent::__construct();
        $this->builder = $builder;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $model = $this->ask("What is the name of the Model?");

        if( !$this->checkIfModelExists($model)){
            $this->error("Model {$model} doesn't exist!");
            return;
        }
        // Get all fields and reverse the order
        $this->fields = array_reverse(
            $this->tagThem(
                $this->getColumnList(new $model())
            )
        );

        if(count($this->fields) == 0){
            $this->error("No Columns found for the model {$model}");
            return;
        }
        $names = array_keys($this->fields);
        do{
            $this->workOnTheCurrentField(array_pop($names),array_pop($this->fields));
        }while($this->confirm('Do you wish to continue?') && count($this->fields) > 0);
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


    public function workOnTheCurrentField($name, $column)
    {
        // Get the field Type
        $option_key = $this->choice(
            "These are the options for the {$column['type']}?",
            $this->getOptionsByType($column['type'])
        );

        $this->builder->add($name, $option_key);

        // Get rules

        // Get visibility
        
    }
}
