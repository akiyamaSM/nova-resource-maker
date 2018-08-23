<?php
namespace Inani\NovaResourceMaker\Helpers;

trait Tagable {


    protected $options = [
        'int' => [
            'ID',
            'Number'
        ],
        'varchar' => [
            'Text',
            'Password',
        ],
        'text' =>[
            'Text',
            'Markdown'
        ],
        'timestamp' => [
            'DateTime'
        ],
        'datetime' => [
            'DateTime'
        ],
        'date' => [
            'Date'
        ]
    ];

    /**
     * Get options by type
     *
     * @param $type
     * @return array
     */
    protected function getOptionsByType($type)
    {
        return isset($this->options[$type])? $this->options[$type] : [];
    }

    /**
     * Get the type of fields reorganized
     *
     * @param $fields
     * @return array
     */
    public function tagThem($fields)
    {
        $tagged = [];
        array_walk($fields, function ($column) use(&$tagged){
            $tagged[$column->Field] = [
                'type' => $this->getCleanedType($column->Type),
                'extra' => $column->Extra,
            ];
        });
        return $tagged;
    }

    /**
     * Get cleaned type
     *
     * @param $type
     * @return string
     */
    public function getCleanedType($type)
    {
        if(strpos($type, 'int') !== false){
            return 'int';
        }

        if(strpos($type, 'varchar') !== false){
            return 'varchar';
        }

        return $type;
    }
}