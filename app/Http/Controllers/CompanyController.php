<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{

/**
 * @OA\Get(
 * path="/api/company",
 * summary="List company",
 * operationId="listCompany",
 * tags={"Company"},
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

        $company= Company::select('companies.*', 'users.name as user')
        ->join('users','users.id','=','companies.user_id')
        ->paginate(10);
        return response()->json($company);
    }

    
    /**
 * @OA\Post(
 * path="/api/company",
 * summary="Register company",
 * operationId="registerComapny",
 * tags={"Company"},
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
 * @OA\Parameter( in="path",  name="currency",  required=true,
 *    @OA\Schema(  type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="description",  required=true,
 *    @OA\Schema(
 *       type="string"
 *    ),
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       @OA\Property(property="name", type="string", format="name", example="Naykana c.a"),
 *       @OA\Property(property="identification_number", type="string", format="identification_number", example="265830250"),
 *       @OA\Property(property="address", type="string", format="address", example="caracas-venezuela"),
 *       @OA\Property(property="phone", type="string", format="phone", example="412 0000 000"),
 *       @OA\Property(property="logo", type="file", format="logo", example= "naykana.jpg"),
 *       @OA\Property(property="currency", type="string", format="currency", example="USD"),
 *       @OA\Property(property="description", type="string", format="description")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Company created successfully")
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
            'identification_number' => 'required|string|max:15',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'logo' => 'image|file|max:1024',
            'currency' => 'required|string|max:20',
            'description' => 'required|string|max:100',                                 
        ];

        $validator= Validator::make($request->input(), $rules);
        

        if ($file = $request->file('logo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/company/';

            $file->storeAs($path, $fileName);
            $request['logo'] = $fileName;
        }

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }

        $customer= new Company($request->input());
        $customer->save();

        return response()->json([
            'status'=> true,
            'message'=> 'Company created successfully'
        ],200);
    }
    
    
    
    /**
 * @OA\Put(
 * path="/api/company/{id}",
 * summary="Update company",
 * operationId="updateComapny",
 * tags={"Company"},
 * 
 *  @OA\Parameter( in="path",  name="id",  required=true,
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
 * @OA\Parameter( in="path",  name="currency",  required=true,
 *    @OA\Schema(  type="string" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="description",  required=true,
 *    @OA\Schema(
 *       type="string"
 *    ),
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="name", type="string", format="name", example="Naykana c.a"),
 *       @OA\Property(property="identification_number", type="string", format="identification_number", example="265830250"),
 *       @OA\Property(property="address", type="string", format="address", example="caracas-venezuela"),
 *       @OA\Property(property="phone", type="string", format="phone", example="412 0000 000"),
 *       @OA\Property(property="logo", type="file", format="logo", example= "naykana.jpg"),
 *       @OA\Property(property="currency", type="string", format="currency", example="USD"),
 *       @OA\Property(property="description", type="string", format="description")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Company updated successfully")
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
    public function update(Request $request, Company $company)
    {
        $rules = [
            'identification_number'=>"require|unique:companies,identification_number,$company->identification_number",
            'name' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'currency' => 'required|string|max:20',
            'description' => 'required|string|max:100',                              
        ];

        $validator= Validator::make($request->input(), $rules);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }

        $company->update($request->input());

        return response()->json([
            'status'=> true,
            'message'=> 'Company updated successfully'
        ],200);
    }


 /**
 * @OA\Delete(
 * path="/api/comapany/{id}",
 * summary="Delete company",
 * operationId="deleteComany",
 * tags={"Company"},
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
 *       @OA\Property(property="message", type="string", example="Company deleted successfully")
 *        )
 *     )
 * )
 */
    public function destroy(Company $company)
    {
        /**
         * Delete photo if exists.
         */
        if($company->logo){
            Storage::delete('public/company/' . $company->logo);
        }

        $company->delete();
        return response()->json([
            'status'=> true,
            'message'=> 'Company deleted successfully'
        ],200);
    }
}
