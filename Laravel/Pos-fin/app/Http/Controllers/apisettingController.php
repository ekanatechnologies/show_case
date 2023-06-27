<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;

class apisettingController extends Controller
{
     public function api(){
         
         $client = new Client();
        $response = $client->post('https://login.microsoftonline.com/6e9d22f8-d9e5-4479-bfef-33ab60f4da24/oauth2/v2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '80947625-9d2f-4632-a386-615d4bc7ae60',
                'client_secret' => 'uiq8Q~akyzDdKcC-kLzpYvw8hbu8~R0oWsZkzbUv',
                'scope' => 'api://2edf8cb4-bf9f-44a4-b68a-3121214d4f2c/.default',
            ]
        ]);

      
         
        return view('products.create',compact('response','text'));
     }
     
     public function searchApi(Request $request){
         
           $client = new Client();
        $response = $client->post('https://login.microsoftonline.com/6e9d22f8-d9e5-4479-bfef-33ab60f4da24/oauth2/v2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '80947625-9d2f-4632-a386-615d4bc7ae60',
                'client_secret' => 'uiq8Q~akyzDdKcC-kLzpYvw8hbu8~R0oWsZkzbUv',
                'scope' => 'api://2edf8cb4-bf9f-44a4-b68a-3121214d4f2c/.default',
            ]
        ]);
      $text = $request->input('text');

        return redirect('/products')-with('test',$test);
        
     }
     
     public function addProduct(Request $request){
         $name=$request->sku;
            return view('apisetting.api',compact('name'));
         
     //return redirect()->route('api')->with('success', __('Product added successfully.'));
        
     }
          public function apiDatanew(){
         
         $client = new Client();
        $response = $client->post('https://login.microsoftonline.com/6e9d22f8-d9e5-4479-bfef-33ab60f4da24/oauth2/v2.0/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => '80947625-9d2f-4632-a386-615d4bc7ae60',
                'client_secret' => 'uiq8Q~akyzDdKcC-kLzpYvw8hbu8~R0oWsZkzbUv',
                'scope' => 'api://2edf8cb4-bf9f-44a4-b68a-3121214d4f2c/.default',
            ]
        ]);

      
         
        return view('apisetting.search',compact('response'));
     }
     

}
