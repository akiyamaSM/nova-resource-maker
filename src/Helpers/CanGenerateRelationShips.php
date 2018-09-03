<?php


namespace Inani\NovaResourceMaker\Helpers;


use ReflectionClass;
use ReflectionMethod;

trait CanGenerateRelationShips
{

    /**
     * Filter the comment
     *
     * @param $comment
     * @return null
     */
    public function getRelationType($comment)
    {
        preg_match('/\*\s*@relation\(\'([A-Z][A-Za-z]+)\'\)/', $comment, $matches);

        return count($matches) > 1 ? $matches[1] : null;
    }

    /**
     * Build Relationships
     *
     * @param $model
     * @return array
     */
    public function buildRelationShips($model)
    {
        $relations = $this->getAllRelationShipsMethods($model);
        // $method->name, $method->relation, $method->field_name

        $tagged = [];

        foreach($relations as $method){
            $tagged[$method->name] = [
                'type' => $method->relation,
                'field_name' => $method->field_name,
            ];
        }
        return $tagged;
    }

    /**
     * Get all the Public Methods
     *
     * @param $model
     * @return array
     */
    public function getAllRelationShipsMethods($model)
    {
        $class = new ReflectionClass($model);
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $cleaned = [];
        foreach($methods as $method){
            if($method->class == $class->getName()){
                $reflectionMethod = new ReflectionMethod($model, $method->name);
                if( ($relation = $this->getRelationType($reflectionMethod->getDocComment())) != null){
                    $method->relation = $relation;
                    $method->field_name = snake_case($method->name, " ");
                    $cleaned[] = $method;
                }

            }
        }

        return $cleaned;
    }
}