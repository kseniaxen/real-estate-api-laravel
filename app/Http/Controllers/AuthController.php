<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    /**
     * AuthController.
     * JSON Response - status (success,failure), message, data
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['login','register','logout','userInfo','refresh','checkUser','editUser']]);
    }

    //Аутентификация пользователя по почте и паролю
    public function login(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required|string|min:4'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            //Токен валиден 1 день. Передача значения в секундах
            $token_validity = (24 * 60);

            $this->guard()->factory()->setTTL($token_validity);

            //Проверка в БД таблицы users пользователя с заранее проверенными данными (email и password) в запросе
            if(!$token = $this->guard()->attempt($validator->validated())){
                return $this->responseContext('failure','Unauthorized user',[],401);
            }

            return $this->responseContext('success','User '.Auth::user()['email'].' token', $this->responseWithToken($token),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }

    }

    //Регистрация пользователя по имени, почте и паролю
    public function register(Request $request){
        try{
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|between:2,100',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string|min:6'
                ]
            );

            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => Hash::make($request->input('password'))]
            ));

            return $this->responseContext('success','User '.Auth::user()['email'].' created',[],201);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    //Выход с учетной записи (удаление токена пользователя)
    public function logout(){
        try{
            if(!$this->guard()->check()) {
                return $this->responseContext('failure','Unauthorized user',[],401);
            }
            $this->guard()->logout();
            return $this->responseContext('success','User '.Auth::user()['email'].' logout',[],200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    //Получение информации о пользователе
    public function userInfo(){
        try{
            if(!$this->guard()->check()) {
                return $this->responseContext('failure','Unauthorized user',[],401);
            }
            return $this->responseContext('success', 'User '.Auth::user()['email'].' info', $this->guard()->user(), 200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    //Обновление токена пользователя
    public function refresh(){
        try{
            if(!$this->guard()->check()) {
                return $this->responseContext('failure','Unauthorized user',[],401);
            }
            return $this->responseContext('success','User '.Auth::user()['email'].' refresh token', $this->responseWithToken($this->guard()->refresh()),200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    //Проверка email пользователя
    public function checkUser(Request $request){
        try{
            $validatorEmail = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                ]
            );

            if($validatorEmail->fails()){
                return $this->responseContext('failure','Invalid data',$validatorEmail->errors(),400);
            }

            $validatorCheckUserEmail = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email|unique:users',
                ]
            );

            if($validatorCheckUserEmail->fails()){
                return $this->responseContext('success',' Check exist email ' . $request->input('email'),['exist' => 'false'],200);
            }
            return $this->responseContext('success',' Check exist email ' . $request->input('email'),['exist' => 'true'],200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    //Изменить данные пользователя
    public function editUser(Request $request){
        try{
            if(!$this->guard()->check()) {
                return $this->responseContext('failure','Unauthorized user',[],401);
            }
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|between:2,100',
                    'email' => 'required|email|unique:users,email,'.Auth::user()['id']
                ]
            );
            if($validator->fails()){
                return $this->responseContext('failure','Invalid data',$validator->errors(),400);
            }

            $user = Auth::user();
            $user->name = $validator->validated()['name'];
            $user->email = $validator->validated()['email'];
            $user->save();
            return $this->responseContext('success','User '.Auth::user()['email'].' update',[],200);
        }catch (Exception $ex){
            return $this->responseContext('failure',$ex->getMessage(),[],$ex->getCode());
        }
    }

    protected function responseWithToken($token){
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'token_validity' => $this->guard()->factory()->getTTL()*60
        ];
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
