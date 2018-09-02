<?php


namespace Inani\NovaResourceMaker\Helpers;


trait FieldsManager
{
    protected $headers = [
        'code', 'method', 'explanation'
    ];

    protected $available_methods = [
        [
            'code' => 0,
            'method' => 'hideFromIndex',
            'explanation' => 'Specify that the element should be hidden from the index view.'
        ],
        [
            'code' => 1,
            'method' => 'hideFromDetail',
            'explanation' => 'Specify that the element should be hidden from the detail view.'
        ],
        [
            'code' => 2,
            'method' => 'hideWhenCreating',
            'explanation' => 'Specify that the element should be hidden from the creation view.'
        ],
        [
            'code' => 3,
            'method' => 'hideWhenUpdating',
            'explanation' => 'Specify that the element should be hidden from the update view.'
        ],
        [
            'code' => 4,
            'method' => 'onlyOnIndex',
            'explanation' => 'Specify that the element should only be shown on the index view.'
        ],
        [
            'code' => 5,
            'method' => 'onlyOnDetail',
            'explanation' => 'Specify that the element should only be shown on the detail view.'
        ],
        [
            'code' => 6,
            'method' => 'onlyOnForms',
            'explanation' => 'Specify that the element should only be shown on forms.'
        ],
        [
            'code' => 7,
            'method' => 'exceptOnForms',
            'explanation' => 'Specify that the element should be hidden from forms.'
        ]
    ];

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

    /**
     * Add visibility methods
     *
     * @param $methods
     * @return $this
     */
    public function addMethods($methods)
    {
        $methods = explode('|', $methods);
        if($this->notValidEntry($methods)){
            return false;
        }

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
     * Check if there are any invalid entry
     *
     * @param $methods
     * @return bool
     */
    protected function notValidEntry($methods)
    {
        $not_valid_elements = array_filter($methods, function($key){
            // not valid range
            if( count($this->available_methods) <= $key || $key < 0 ){
                return true;
            }

            // not a integer
            if( !is_numeric($key)){
                return true;
            }

            return false;
        });

        return count($not_valid_elements) > 0 ;
    }
}