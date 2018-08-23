<?php
namespace Inani\NovaResourceMaker\Helpers;

trait Tagable {

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

        return $type;
    }
}