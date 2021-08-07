<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class CountryController extends Controller
{
    /**
     * CountryController constructor.
     */
    public function __construct()
    {

    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:countries'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $country = Country::create(array_merge($validator->validated()));
            return $this->responseContext('success','Create '.$country['name'].' country', [],201);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function edit(Request $request, $id){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:countries,name,'.Country::find($id)['id']
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $country = Country::whereId($id)->update($request->all());
            return $this->responseContext('success','Edit '.Country::find($id)['name'].' country', [],200);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function delete(Request $request, $id){
        try{
            $validator = Validator::make(
                ['id' => $id],
                ['id' => 'required|integer']
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            Country::destroy($id);

            return $this->responseContext('success','Delete country', [],204);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getAll(){
        try{
            return $this->responseContext('success','Get all countries', Country::all(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getCountryById(Request $request, $id){
        try{
            $validator = Validator::make(
                ['id' => $id],
                ['id' => 'required|integer']
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }
            return $this->responseContext('success','Get country', Country::find($id),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getByName(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'string'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            return $this->responseContext('success','Get name with start', Country::where('name','LIKE',$request->input('start').'%')->get(),200);
        }catch(Exception $ex){
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
