<?php
namespace App\Services;

use Validator;
use App\Services\BaseService;
use App\Exceptions\ValidatorException;
use Illuminate\Validation\Rule;

class EstadoCivilService extends BaseService
{
    
    public function lists(){
        return $this->model->paginate();
    }

    public function find($id){
        $registro = $this->model->find($id);
        return $registro;
    }

}
