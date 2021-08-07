<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:cities',
                    'countryId' => 'required|integer|exists:countries,id'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $city = City::create(array_merge($validator->validated()));
            return $this->responseContext('success','Create '.$city['name'].' city', [],201);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function edit(Request $request, $id){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|min:1|unique:cities,name,'.City::find($id)['id'],
                    'countryId' => 'required|integer|exists:countries,id'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $city = City::whereId($id)->update($request->all());
            return $this->responseContext('success','Edit '.City::find($id)['name'].' city', [],200);
        }catch (Exception $ex){
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

            City::destroy($id);

            return $this->responseContext('success','Delete city', [],204);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getCityByCountryId(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'country' => 'integer',
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $city = DB::table('cities')->where('countryId',$request->query('country'))->get();
            return $this->responseContext('success','Get city',$city,200);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getCityById(Request $request, $id){
        try{
            return $this->responseContext('success','Get city', City::find($id),200);
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
