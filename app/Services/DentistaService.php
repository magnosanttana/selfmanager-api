<?php
namespace App\Services;

use Validator;
use App\Services\BaseService;
use App\Exceptions\ValidatorException;
use Illuminate\Validation\Rule;

class DentistaService extends BaseService
{
    
    public function lists(){
        return $this->model->orderBy('name', 'asc')->paginate(5);
    }

    public function create ($data){
        
        $this->validate($data);
        try{
            return \DB::transaction(function () use($data){
            
                $registro =  $this->model->create($data);
    
                foreach($data['phones'] as $phone){
                    $registro->phones()->create($phone);
                }

                //UPLOAD
                if(!empty($data['license']))
                    $registro = $this->uploadAlvara($registro, $data['license']);
                
                return $registro;

            });
            
        }catch(\Exception $e){
            throw new ValidatorException(['Falha ao tentar salvar registro. Tente novamente e se o erro persistir contate o suporte ;) ']);
        }
        
    }

    public function find($id){
        $registro = $this->model->with(['phones','marital'])->find($id);
        return $registro;
    }

    public function update($data, $id){
        $this->validate($data, $id);

        try{
            return \DB::transaction(function () use ($data, $id){
                
                $registro = $this->find($id);
                $registro->update($data);
                $registro->phones()->delete();
                foreach($data['phones'] as $phone){
                    $registro->phones()->create($phone);
                }

                if(!empty($data['license']))
                    $registro = $this->uploadAlvara($registro, $data['license']);
                
                return $registro;
    
            });
    

        }catch(\Exception $e){
            throw new ValidatorException(['Falha ao tentar salvar registro. Tente novamente e se o erro persistir contate o suporte ;) ']);
        }
        
    }

    public function delete($id){
        try{
            \DB::transaction(function () use ($id){
                
                $registro = $this->find($id);
                $registro->phones()->delete();
                $registro->delete($id);

                if(!\Storage::disk('public')->delete($registro->license)){
                    throw new \Exception;
                }
    
            });
    
            return [];

        }catch(\Exception $e){
            //return $e;
            throw new ValidatorException(['Falha ao tentar excluir registro. Tente novamente e se o erro persistir contate o suporte ;) ']);
        }
        
    }

    protected function validate($data, $idRegistro = null){
        $rules = [
            'cpf'                       => 'required|max:11',
            'email'                     => 'required|unique:dentists|max:255',
            'name'                      => 'required|max:255',
            'gender'                    => 'required|max:1',
            'date_of_birth'             => 'required',
            'rg'                        => 'required|max:255',
            'agency'                    => 'required|max:255',
            'marital_status_id'         => 'required',
            'nationality'               => 'required|max:255',
            'place_of_birth'            => 'required|max:255',
            'address_postcode'          => 'required|max:255',
            'address_address'           => 'required|max:255',
            'address_number'            => 'required|max:255',
            'address_secondary_address' => 'max:255',
            'address_city'              => 'required|max:255',
            'address_state'             => 'required|max:2',
            'license'                   => 'required|file|mimes:pdf,docx,jpeg,png,gif|max:3072', //o ideal é validar pelo MIME type e nao extensao
        ];

        if($idRegistro){

            $rules['email'] = [
                'required',
                'max:255',
                Rule::unique('dentists')->ignore($idRegistro)
            ];

            $rules['license'] = 'file|mimes:pdf,docx,jpeg,png,gif|max:3072';

        }

        
        $validator = Validator::make($data, $rules, [], 
        [
            'date_of_birth'             => 'data de nascimento',
            'agency'                    => 'orgao expedidor',
            'marital_status_id'         => 'estado civil',
            'nationality'               => 'nacionalidade',
            'place_of_birth'            => 'cidade de nascimento',
            'address_postcode'          => 'cep',
            'address_address'           => 'endereço',
            'address_number'            => 'numero',
            'address_secondary_address' => 'complemento',
            'address_city'              => 'cidade',
            'address_state'             => 'uf',
            'phones'                    => 'telefone',
            'license'                   => 'alvará'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException($validator->errors()->all());
        }

        if(!isset($data['phones']) || !count($data['phones'])){
            throw new ValidatorException(['É necessário informar ao menos um número de telefone']);
        }elseif(empty($data['phones'][0]['type']) || empty($data['phones'][0]['number'])){
            throw new ValidatorException(['É necessário informar ao menos um número de telefone (tipo e número)']);
        }

    }

    protected function uploadAlvara($entity, $file){
        
        if($file->isValid()){
            $novoNome = md5($entity->id.date('Y-m-d h:i:s')).'.'.$file->extension();
            $path = $file->storeAs('alvaras', $novoNome,'public');

            $arquivoAnterior = $entity->license;

            $entity->license = $path;
            $entity->save();

            \Storage::disk('public')->delete($arquivoAnterior);

        }
        
        return $entity;

    }
}
