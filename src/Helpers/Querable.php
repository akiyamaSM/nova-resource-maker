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
}