<?php


namespace Inani\NovaResourceMaker\Helpers;


class FieldsBuilder
{

    protected $fileds = [];

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
        $this->fileds [$name] ['type'] = $type;

        return $this;
    }

    /**
     * Add Rule
     *
     * @param $rule
     */
    public function addRules($rule)
    {
        $rules = explode('|', $rule);
        $this->fileds[$this->current] ["rules"] = $rules;
    }

    public function getQueryBuilder()
    {
        return $this->fileds;
    }

    /**
     *  Generate the fields
     *
     */
    public function build()
    {
        foreach($this->fileds as $name => $field){
            echo "{$field['type']}::make('". snake_case($name) ."','{$name}')";
            if(isset($field['rules'])){
                echo "->rule('". implode("', '", $field['rules']) ."')";
                echo ";" .PHP_EOL;
            }
        }
    }
}