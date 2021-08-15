<?php

namespace App\Http\Controllers;

use App\Filters\ApartmentFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\House;

class HouseCommonController extends Controller
{
    public function __construct(){

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
            return $this->responseContext('success','Get all houses by section', House::whereIn('id',$array_id)->get(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getTotalCount(){
        try{
            return $this->responseContext('success','Get total count houses', House::count(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function filter(ApartmentFilter $request){
        $houses = House::filter($request)->get();
        return $this->responseContext('success','Filter houses', $houses,200);
    }

    protected function responseContext($status, $message, $data, $statusCode){
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }
}