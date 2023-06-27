<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
         $client = new Client();
        $response = $client->post('https://login.microsoftonline.com/6e9d22f8-d9e5-4479-bfef-33ab60f4da24/oauth2/v2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '80947625-9d2f-4632-a386-615d4bc7ae60',
                'client_secret' => 'uiq8Q~akyzDdKcC-kLzpYvw8hbu8~R0oWsZkzbUv',
                'scope' => 'api://2edf8cb4-bf9f-44a4-b68a-3121214d4f2c/.default',
            ]
        ]);
        
       
            $body = json_decode((string) $response->getBody(),true);
            $accesstoken = $body['access_token']."<br>";
            $token_type = $body['token_type'];
 
            $url = "https://apim-posdata-uat-cencan-001.azure-api.net/func-inventory-position-uat-cencan-001/POSInventoryEventFunction?crsa=CRSA1241576&posStartDate=2023-04-10T09:31:30Z&posEndDate=2023-04-17T09:31:30Z&pageNumber=1";
            $curl = curl_init($url);
            
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            # Request headers
            $headers = array(
                'retailer_hashkey: E46B3611415796E8524CC483969193EB5087C7A02097F8F286387ABAA11A6283',
                'Authorization: '.$body['access_token'],
                'Content-Type: application/json',);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $results = curl_exec($curl);
            curl_close($curl);
            
            
// var_dump($resp);

$result = DB::table('invntory')->get();
$res= DB::select("select `products`.`id` as 'id',`branches`.`name` as 'Branch',`inventories`.`quantity`as 'Quantity',`products`.`name`,`products`.`sku`,`products`.`image`,`brands`.`name` as 'Brand',`categories`.`name` as 'Category'
from `products` 
inner join `inventories` 
    on `inventories`.`product_id` = `products`.`id` 
inner join `branches` 
    on `branches`.`id` = `inventories`.`branch_id`
   inner join `brands` 
    on `brands`.`id` = `products`.`brand_id`
    inner join `categories` 
    on `categories`.`id` = `products`.`category_id`;");


            
        return view('Inventory.overview',compact('result','results','res'));
    }
   // audits
     public function audits()
    {
     
        $result= DB::select("select * from audits");
        return view('Inventory.audits',compact('result'));
    }

    public function auditStore(Request $request){

        DB::table('audits')->insert(
            ['title' => $request->title, 'secret_id' =>$request->secret_id,'location'=>$request->location,'created_by'=>Auth::user()->getName(),'status'=>'pending','completed'=>'-']
        );
        $result= DB::select("select * from audits");
        return view('Inventory.audits',compact('result'));
    }


    //transfers
     public function transfers()
    {
     
    
        return view('Inventory.transfers');
    }
    // Low stock alerts
     public function lowstockalerts()
    {
     

        return view('Inventory.lowstockalerts');
    }
    public function alerts(){
        return view('Inventory.alerts');

    }

    public function create(){
        return view('Inventory.create');
    }
    public function store(Request $request){

       
        $client = new Client();
        $response = $client->post('https://login.microsoftonline.com/6e9d22f8-d9e5-4479-bfef-33ab60f4da24/oauth2/v2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '80947625-9d2f-4632-a386-615d4bc7ae60',
                'client_secret' => 'uiq8Q~akyzDdKcC-kLzpYvw8hbu8~R0oWsZkzbUv',
                'scope' => 'api://2edf8cb4-bf9f-44a4-b68a-3121214d4f2c/.default',
            ]
        ]);
        
       
            $body = json_decode((string) $response->getBody(),true);
            $accesstoken = $body['access_token']."<br>";
            $token_type = $body['token_type'];



        $url = "https://apim-posdata-uat-cencan-001.azure-api.net/func-inventory-position-uat-cencan-001/PosInventoryEventHttpTrigger?posVendor=Jessie%20Pos&posVendorVersion=Jessie%20Pos%20Version&retailerCRSA=CRSA1241576";
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        # Request headers
        $headers = array(
            'retailer_hashkey: E46B3611415796E8524CC483969193EB5087C7A02097F8F286387ABAA11A6283',
            'Authorization: '.$body['access_token'],
            'Content-Type: application/json',);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        # Request body
        $request_body = '{
            "inventoryEventList": [{
                "ocsSku": "'.$request->sku.'",
                "upcAndBarcode": "'.$request->sku.'",
                "posTransactionTimeStamp": "2023-04-17T09:31:30Z",
                "posTransactionLineId": "'.uniqid().'",
                "inventoryEventType": "SALE",
                "inventoryQuantityChange": "'.$request->qc.'",
                "inventoryValueChange": "'.$request->vc.'",
                "posSalesTransactionId": "'.$request->tid.'",
                "soldAtPrice": "'.$request->soldAtPrice.'",
                "counterPartyCRSA": "CRSA1234567",
                "reasonCategory": "'.$request->rc.'",
                "processOnDate": "'.date("Y-m-d").'"
            }]
        }';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
        
        $resp = curl_exec($curl);
        curl_close($curl);
        

        

        $result = DB::table('invntory')->get();


        return view('Inventory.overview',compact('resp','result'));
    }
}