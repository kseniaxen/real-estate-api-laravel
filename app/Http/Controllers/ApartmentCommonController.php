<?php

namespace App\Http\Controllers;

use App\Filters\ApartmentFilter;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApartmentCommonController extends Controller
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
            return $this->responseContext('success','Get all apartments by section', Apartment::whereIn('id',$array_id)->
                with('country')->
                with('city')->
                with('currency')->
                with('type')->
                with('typeproperty')->
                get(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function getTotalCount(){
        try{
            return $this->responseContext('success','Get total count apartments', Apartment::count(),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    public function filter(ApartmentFilter $request){
        $apartments = Apartment::filter($request)->
            with('country')->
            with('city')->
            with('currency')->
            with('type')->
            with('typeproperty')->
            get();
        return $this->responseContext('success','Filter apartments', $apartments,200);
    }

    public function getLastFour(){
        try{
            return $this->responseContext('success','Get last four apartments', Apartment::orderBy('created_at', 'desc')->take(4)->
                with('country')->
                with('city')->
                with('currency')->
                with('type')->
                with('typeproperty')->
                get(),200);
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
