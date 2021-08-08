<?php

namespace App\Http\Controllers;

use App\Models\TypeProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class TypePropertyController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:type_properties'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $typeProperty = TypeProperty::create(array_merge($validator->validated()));
            return $this->responseContext('success','Create '.$typeProperty['name'].' type property', [],201);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function edit(Request $request, $id){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:type_properties,name,'.TypeProperty::find($id)['id']
                ]
            );
            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $type = TypeProperty::whereId($id)->update($request->all());
            return $this->responseContext('success','Edit '.TypeProperty::find($id)['name'].' type property', [],200);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function delete($id){
        try{
            $validator = Validator::make(
                ['id' => $id],
                ['id' => 'required|integer']
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            TypeProperty::destroy($id);
            return $this->responseContext('success','Delete type property', [],204);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getAll(){
        try{
            return $this->responseContext('success','Get all types properties', TypeProperty::all(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    protected function responseContext($status, $message, $data, $statusCode){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }
}
