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

    public function build()
    {
        foreach($this->fileds as $field){
            echo "{$field['type']}::make()";
            if(isset($field['rules'])){
                echo "->rule('". implode("', '", $field['rules']) ."')";
            }
        }
    }
}