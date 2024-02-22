<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{

/**
 * @OA\Get(
 * path="/api/customer",
 * summary="List customers",
 * operationId="listCustomer",
 * tags={"Customers"},
 * 
 * 
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true")
 *        )
 *     )
 * )
 */
    public function index()
    {
        $customer= Customer::select('customers.*', 'users.name as user')
        ->join('users','users.id','=','customers.user_id')
        ->paginate(10);
        return response()->json($customer);
    }

    

    /**
 * @OA\Post(
 * path="/api/customer",
 * summary="Register customer",
 * operationId="registerCustomer",
 * tags={"Customers"},
 * 
 * @OA\Parameter( in="path",  name="name",  required=true,
 *     @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="identification_number",  required=true,
 *    @OA\Schema( type="string" ),
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
 * @OA\Parameter( in="path",  name="logo",  required=true,
 *    @OA\Schema( type="file" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="company",  required=true,
 *    @OA\Schema(
 *       type="string"
 *    ),
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       @OA\Property(property="name", type="string", format="name", example="jose alberto"),
 *       @OA\Property(property="identification_number", type="string", format="identification_number", example="265830250"),
 *       @OA\Property(property="address", type="string", format="address", example="caracas-venezuela"),
 *       @OA\Property(property="phone", type="string", format="phone", example="412 0000 000"),
 *       @OA\Property(property="logo", type="file", format="logo", example= "jose.jpg"),
 *       @OA\Property(property="company", type="string", example="jse c.a")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Customer created successfully")
 *        ),
 *     ),
 * 
 *  @OA\Response(
 *    response=400,
 *    description="Bad Request",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="false"),
 *       @OA\Property(property="message", type="string", example="errors")
 *        )
 *     )
 * )
 */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'logo' => 'image|file|max:1024',
            'company' => 'required|string|max:50',
            'identification_number' => 'required|string|max:15',                      
        ];

        $validator= Validator::make($request->input(), $rules);
        

        if ($file = $request->file('logo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';

            $file->storeAs($path, $fileName);
            $request['logo'] = $fileName;
        }

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }
        
        $customer= new Customer($request->input());
        $customer->save();

        return response()->json([
            'status'=> true,
            'message'=> 'Customer created successfully'
        ],200);


    }

    

        /**
 * @OA\Put(
 * path="/api/customer/{id}",
 * summary="Update customer",
 * operationId="updateCustomer",
 * tags={"Customers"},
 * 
 * @OA\Parameter( in="path",  name="id",  required=true,
 *     @OA\Schema( type="integer" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="name",  required=true,
 *     @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="identification_number",  required=true,
 *    @OA\Schema( type="string" ),
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
 * @OA\Parameter( in="path",  name="logo",  required=true,
 *    @OA\Schema( type="file" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="company",  required=true,
 *    @OA\Schema(
 *       type="string"
 *    ),
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       @OA\Property(property="name", type="string", format="name", example="jose alberto"),
 *       @OA\Property(property="identification_number", type="string", format="identification_number", example="265830250"),
 *       @OA\Property(property="address", type="string", format="address", example="caracas-venezuela"),
 *       @OA\Property(property="phone", type="string", format="phone", example="412 0000 000"),
 *       @OA\Property(property="logo", type="file", format="logo", example= "jose.jpg"),
 *       @OA\Property(property="company", type="integer", example="1")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Customer updated successfully")
 *        ),
 *     ),
 * 
 *  @OA\Response(
 *    response=400,
 *    description="Bad Request",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="false"),
 *       @OA\Property(property="message", type="string", example="errors")
 *        )
 *     )
 * )
 */
    public function update(Request $request, Customer $customer)
    {
        $rules = [
            'identification_number'=>"require|unique:customers,identification_number,$customer->identification_number",
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'company' => 'required|string',
        ];

        $validator= Validator::make($request->input(), $rules);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }

        $customer->update($request->input());
        return response()->json([
            'status'=> true,
            'message'=> 'Customer updated successfully'
        ],200);
    }

    
    /**
 * @OA\Delete(
 * path="/api/customer/{id}",
 * summary="Delete customer",
 * operationId="deletecustomer",
 * tags={"Customers"},
 * 
 * @OA\Parameter( in="path",  name="id",  required=true,
 *     @OA\Schema( type="integer" ),
 * ),
 * 
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Customer deleted successfully")
 *        )
 *     )
 * )
 */
    public function destroy(Customer $customer)
    {

        /**
         * Delete photo if exists.
         */
        if($customer->logo){
            Storage::delete('public/customers/' . $customer->logo);
        }

        $customer->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Customer deleted successfully'
        ],200);
    }
}
