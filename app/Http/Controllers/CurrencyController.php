<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CurrencyController extends Controller
{
    public function __construct()
    {

    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:currencies'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $currency = Currency::create(array_merge($validator->validated()));
            return $this->responseContext('success','Create '.$currency['name'].' currency', [],201);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function edit(Request $request, $id){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:currencies,name,'.Currency::find($id)['id']
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $currency = Currency::whereId($id)->update($request->all());
            return $this->responseContext('success','Edit '.Currency::find($id)['name'].' currency', [],200);
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

            Currency::destroy($id);

            return $this->responseContext('success','Delete currency', [],204);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getAll(){
        try{
            return $this->responseContext('success','Get all currencies', Currency::all(),200);
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
