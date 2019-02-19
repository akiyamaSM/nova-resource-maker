<?php


namespace Inani\NovaResourceMaker\Helpers;


class FieldsBuilder
{
    use FieldsManager;
    /*
     *  Array of fields
     */
    protected $fields = [];

    /*
     * Current field
     */
    protected $current;

    /**
     * Add a new Field to the array
     *
     * @param $name
     * @param $type
     * @return $this
     */
    public function add($name, $type)
    {
        $this->current = $name;
        $this->fields [$name] ['type'] = $type;

        return $this;
    }


    public function getQueryBuilder()
    {
        return $this->fields;
    }

    /**
     *  Generate the fields
     *
     */
    public function build()
    {
        foreach($this->fields as $name => $field){
            echo "{$field['type']}::make('". snake_case($name) ."','{$name}')";
            // rules
            if(isset($field['rules'])){
                echo "->rules('". implode("', '", $field['rules']) ."')";
            }

            // Visibilities
            if(isset($field['visibility'])){
                echo "->" . implode("()->", $field['visibility']) . "()";
            }

            if(isset($field['sortable'])){
                echo "->sortable()";
            }
            echo "," .PHP_EOL;

        }
    }

}
