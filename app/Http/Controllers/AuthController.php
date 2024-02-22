<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
/**
 * @OA\Post(
 * path="auth/register",
 * summary="Register",
 * operationId="registerLogin",
 * tags={"Auth"},
 * 
 * @OA\Parameter( in="path",  name="name",  required=true,
 *     @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="address",  required=true,
 *    @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="phone",  required=true,
 *    @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="email",  required=true,
 *    @OA\Schema(  type="email" ),
 *  ),
 * @OA\Parameter( in="path",  name="password",  required=true,
 *    @OA\Schema(
 *       type="password"
 *    ),
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="name", type="string", format="name", example="user"),
 *       @OA\Property(property="address", type="string", format="address", example="caracas-venezuela"),
 *       @OA\Property(property="phone", type="string", format="phone", example="412 0000 000"),
 *       @OA\Property(property="email", type="string", format="email", example="user@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345")
 *    ),
 * ),
 * @OA\Response(
 *    response=401,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Unauthorized")
 *        )
 *     )
 * )
 */
public function create(Request $request){

        $rules= [
            'name'=> 'required|string|max:100',
            'address' => 'required|string|max:100',
            'phone' => 'required|numeric',
            'email'=> 'required|string|email|max:100|unique:users',
            'password'=> 'required|string|min:8'
        ];

        $validator= Validator::make($request->input(), $rules);
        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }

        $user= User::create([
            'name'=> $request->name,
            'address'=> $request->address,
            'phone'=> $request->phone,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);
        
        return response()->json([
            'status'=> true,
            'message'=> 'User created sucessfully',
            'token'=> $user->createToken('API TOKEN')->plainTextToken
        ],200);
    }



    /**
 * @OA\Post(
 * path="auth/login",
 * summary="Sign in",
 * operationId="authLogin",
 * tags={"Auth"},
 * 
 * @OA\Parameter( in="path",  name="email",  required=true,
 * @OA\Schema( type="email" ),),
 * 
 * @OA\Parameter( in="path",  name="password",  required=true,
 * @OA\Schema( type="password" ),),
 * 
 * @OA\RequestBody(  required=true,
 * @OA\JsonContent( required={"email","password"},
 * 
 * @OA\Property(property="email", type="string", format="email", example="user@mail.com"),
 * @OA\Property(property="password", type="string", format="password", example="PassWord12345")
 *    ),),
 * 
 * @OA\Response(
 *    response=401,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Unauthorized")
 *        )
 *     )
 * )
 */
public function login(Request $request){

    $rules= [
        'email'=> 'required|string|email|max:100',
        'password'=> 'required|string'
    ];

    $validator= Validator::make($request->input(), $rules);
    if($validator->fails()){
        return response()->json([
            'status'=> false,
            'errors'=> $validator->errors()->all()
        ], 400);
    }

    if(!Auth::attempt($request-> only('email','password'))){
        return response()->json([
                'status'=> false,
                'errors'=> ['Unauthorized']
            ], 401);
    }

    $user= User::where('email', $request->email)->first();
    return response()->json([
        'status'=> true,
        'message'=> 'User logged in sucessfully',
        'data'=> $user,
        'token'=> $user->createToken('API TOKEN')->plainTextToken
    ],200);

}


/**
 * @OA\Get(
 * path="/api/logout",
 * summary="Sign out",
 * operationId="logout",
 * tags={"Auth"},
 * 
 * 
 * @OA\Response(
 *    response=200,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="User logged out sucessfully")
 *        )
 *     )
 * )
 */
public function logout(){
    auth()->user()->tokens()->delete();
    return response()->json([
        'status'=> true,
        'message'=> 'User logged out sucessfully'
    ],200);
}
}
