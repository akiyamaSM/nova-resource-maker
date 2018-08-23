<?php
namespace Inani\NovaResourceMaker\Helpers;

use Illuminate\Support\Facades\DB;

trait Querable {

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

    /**
     * Get the name of existing columns
     *
     * @return array
     */
    public function getExistingFields()
    {
        return array_keys($this->fields);
    }

    /**
     * Get the selected element and remove it formn the array
     *
     * @param $element
     * @return mixed
     */
    public function popElement($element)
    {
        $selected = $this->fields[$element];
        unset($this->fields[$element]);

        return $selected;
    }
}