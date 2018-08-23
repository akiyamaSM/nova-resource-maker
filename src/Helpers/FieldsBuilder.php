<?php


namespace Inani\NovaResourceMaker\Helpers;


class FieldsBuilder
{

    protected $fileds = [];

    public function add($name, $type)
    {
        $this->fileds [$name] ['type'] = $type;

        return $this;
    }

    public function getQueryBuilder()
    {
        return $this->fileds;
    }
}