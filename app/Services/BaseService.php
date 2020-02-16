<?php

namespace App\Services;

/*
IMPLEMENTAR AQUI METODOS QUE SEJAM COMUNS À TODAS AS SERVICES
*/
abstract class BaseService
{
    protected $model;
    protected $modelName = '';
    protected $isModel = true;

    public function __construct()
    {
        if($this->isModel){
            if(!$this->modelName)
            {
                $classExp = explode('\\', get_class($this));
                $className = array_pop($classExp);
                $modelName = str_replace('Service', '', $className);
                $this->model = app('App\\Models\\'. $modelName);
            }
            else
            {
                $this->model = app($this->modelName);
            }
        }


    }

}