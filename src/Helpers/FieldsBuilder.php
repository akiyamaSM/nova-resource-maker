<?php


namespace Inani\NovaResourceMaker\Helpers;


class FieldsBuilder
{

    protected $fields = [];

    protected $headers = [
      'code', 'method', 'explanation'
    ];

    protected $available_methods = [
        [
            'code' => 0,
            'method' => 'hideFromIndex',
            'explantation' => ''
        ],
        [
            'code' => 1,
            'method' => 'hideFromDetail',
            'explantation' => ''
        ],
        [
            'code' => 2,
            'method' => 'hideWhenCreating',
            'explantation' => ''
        ],
    ];
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

    /**
     * Add Rule
     *
     * @param $rule
     */
    public function addRules($rule)
    {
        $rules = explode('|', $rule);
        $this->fields[$this->current] ["rules"] = $rules;
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
                echo "->rule('". implode("', '", $field['rules']) ."')";
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

    /**
     * Draw available methods
     *
     * @return array
     */
    public function drawAvailableRules()
    {
        return [$this->headers, $this->available_methods];
    }

    /**
     * Add visibility methods
     *
     * @param $methods
     * @return $this
     */
    public function addMethods($methods)
    {
        $methods = explode('|', $methods);
        foreach($methods as $method){
            $this->fields[$this->current] ["visibility"] [] = $this->available_methods[$method]['method'];
        }

        return $this;
    }

    /**
     * Make the field sortable
     *
     */
    public function sortable()
    {
        $this->fields[$this->current]['sortable'] = true;
    }
}