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
        if (DB::connection()->getConfig("driver") === "pgsql") {
            $schema = DB::connection()->getConfig("schema");
            return collect(
                DB::select(
                    DB::raw("
                        SELECT data_type AS Type,
                            column_name AS Field,
                            NULL AS Extra
                        FROM information_schema.columns
                        WHERE table_schema = '{$schema}'
                            AND table_name   = '{$table}'
                    ")
                )
            )
            ->map(function ($result) {
                $field = new stdClass;
                $field->Type = $result->type;
                $field->Field = $result->field;
                $field->Extra = $result->extra;

                return $field;
            })
            ->toArray();
        }

        return DB::select(DB::raw("SHOW COLUMNS FROM {$table}"));
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
     * Get the selected element and remove it from the array
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
