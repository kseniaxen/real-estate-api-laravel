<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\House;

class HouseController extends Controller
{
    protected $user;
    /**
     * ApartmentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    public function create(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'userId' => 'required|integer|exists:users,id',
                    'type_propertyId' => 'required|integer|exists:type_properties,id',
                    'typeId' => 'required|integer|exists:types,id',
                    'countryId' => 'required|integer|exists:countries,id',
                    'cityId' => 'required|integer|exists:cities,id',
                    'currencyId' => 'required|integer|exists:currencies,id',
                    'unitId' => 'required|integer|exists:units,id',
                    'rooms' => 'required|integer|between:1,10',
                    'area' => 'required|numeric',
                    'residential_area' => 'numeric',
                    'kitchen_area' => 'numeric',
                    'land_area' => 'required|numeric',
                    'floors' => 'required|integer',
                    'price' => 'required|numeric',
                    'description' => 'string',
                    'title' => 'required|string',
                    'image' => 'string'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $house = House::create(array_merge($validator->validated()));
            return $this->responseContext('success','Create '.$house['title'].' house', [],201);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function edit(Request $request, $id){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'userId' => 'required|integer|exists:users,id',
                    'type_propertyId' => 'required|integer|exists:type_properties,id',
                    'typeId' => 'required|integer|exists:types,id',
                    'countryId' => 'required|integer|exists:countries,id',
                    'cityId' => 'required|integer|exists:cities,id',
                    'currencyId' => 'required|integer|exists:currencies,id',
                    'unitId' => 'required|integer|exists:units,id',
                    'rooms' => 'required|integer|between:1,10',
                    'area' => 'required|numeric',
                    'residential_area' => 'numeric',
                    'kitchen_area' => 'numeric',
                    'land_area' => 'required|numeric',
                    'floors' => 'required|integer',
                    'price' => 'required|numeric',
                    'description' => 'string',
                    'title' => 'required|string',
                    'image' => 'string'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            House::whereId($id)->update($request->all());
            return $this->responseContext('success','Edit '.House::find($id)['title'].' house' , [],200);
        }catch (Exception $ex){
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

            House::destroy($id);

            return $this->responseContext('success','Delete house', [],204);
        }catch(Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getAllBySection(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'start' => 'required|integer',
                    'end' => 'required|integer',
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $array_id = range($request->input('start'), $request->input('end'),1);
            return $this->responseContext('success','Get all houses by section', House::where('userId',$this->guard()->id())->whereIn('id',$array_id)->get(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getTotalCount(){
        try{
            return $this->responseContext('success','Get total count houses', House::where('userId',$this->guard()->id())->count(),200);
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

    protected function guard(){
        return Auth::guard();
    }
}
