<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    
/**
 * @OA\Get(
 * path="/api/invoice",
 * summary="List invoice",
 * operationId="listInvoice",
 * tags={"Invoice"},
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
        $invoice= Invoice::select('invoices.*', 'companies.name as company', 'customers.name as customer')
        ->join('companies','companies.id','=','invoices.company_id')
        ->join('customers','customers.id','=','invoices.customer_id')
        ->get();
        return response()->json($invoice);
    }


    /**
 * @OA\Post(
 * path="/api/invoice",
 * summary="Create invoice",
 * operationId="createInvoice",
 * tags={"Invoice"},
 * 
 * @OA\Parameter( in="path",  name="company_id",  required=true,
 *     @OA\Schema( type="integer" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="customer_id",  required=true,
 *     @OA\Schema( type="integer" ),
 *  ),
 * @OA\Parameter( in="path",  name="product",  required=true,
 *     @OA\Schema( type="object" ),
 *  ),
 * 
 * @OA\Parameter( in="path",  name="tax",
 *    @OA\Schema( type="string" ),
 *  ),
 * 
 * @OA\RequestBody(
 *    required=true,
 *    @OA\JsonContent(
 *       @OA\Property(property="company_id", type="integer",  example="1"),
 *       @OA\Property(property="customer_id", type="integer", example="1"),
 *       @OA\Property(property="product", type="object", 
 *        example= "[{ 'name' :  cocina, quantity : 2, unit_price : 5.00 }]"),
 *       @OA\Property(property="tax", type="float")
 *    ),
 * ),
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="message", type="string", example="Invoice created successfully"),
 *       @OA\Property(property="data", type="object")
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
            'company_id' => 'required',
            'customer_id' => 'required',
            'product' => 'required',
            'total' => 'required',                     
        ];

        $validator= Validator::make($request->input(), $rules);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors()->all()
            ], 400);
        }

        $id_company= Company::find($request->company_id);
        $name_company= $id_company->name;

        $numero_factura= random_int(10000,99999);
        $correlative= $name_company."-".$numero_factura;

        $invoice= new Invoice();
        $invoice->company_id = $request->input('company_id');
        $invoice->customer_id = $request->input('customer_id');
        $invoice->total = $request->input('total');
        $invoice->tax = $request->input('tax');
        $invoice->product = $request->input('product');
        $invoice->correlative= $correlative;
        $invoice->save();

        return response()->json([
            'status'=> true,
            'message'=> 'Invoice created successfully',
            'data'=> $invoice
        ],200);
    }


    /**
 * @OA\Get(
 * path="/api/invoice/{id}",
 * summary="Download invoice",
 * operationId="invoiceDownload",
 * tags={"Invoice"},
 * 
 * 
 * @OA\Response(
 *    response=200,
 *    description="OK",
 *    @OA\JsonContent(
 *       @OA\Property(property="status", type="boolean", example="true"),
 *       @OA\Property(property="data", type="object")
 *        )
 *     )
 * )
 */
    public function invoiceDownload(Int $invoice_id)
    {
        $invoice = Invoice::where('id', $invoice_id)->first();
        return response()->json([
            'status'=> true,
            'data'=> $invoice
        ]);
    }
}
