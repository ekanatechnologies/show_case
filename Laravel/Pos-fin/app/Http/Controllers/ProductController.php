<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductExport;
use App\Models\Utility;
use App\Imports\ProductImport;
use App\Imports\VendorImport;
use GuzzleHttp\Client;
use App\Models\Branch;
use App\Models\Inventory;



class ProductController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->getCreatedBy();
        if (Auth::user()->can('Manage Product')) {
            
            $products = Product::getallproducts()->get();
              $categories = Category::where('created_by', $user_id)->get();
              $brands = Brand::where('created_by', $user_id)->get();
            $category = Category::all();
            
            $unit = Unit::all();
            $barcode  = [
                'barcodeType' => Auth::user()->barcodeType() == '' ? 'C128' : Auth::user()->barcodeType(),
                'barcodeFormat' => Auth::user()->barcodeFormat() == '' ? 'css' : Auth::user()->barcodeFormat(),
            ];
            $tax = Tax::all();
            return view('products.index', compact('products', 'barcode','tax','category','brands','user_id','categories','unit'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    public function ajax_call($id){
        $subcategories = Category::where('id', '=',$id)->get();
    //return Response::json($subcategories);
        return $subcategories;
    }
    
    
       public function ajax_product($keyword){
             $user_id = Auth::user()->getCreatedBy();
            // $product = Product::whereLike('name', $keyword)->get();
    
      $product = Product::where('name', 'LIKE', '%'.$keyword.'%')->where('created_by', $user_id)
        ->get();
    
        return $product;
    }

    public function create()
    {
        $user_id = Auth::user()->getCreatedBy();
        if (Auth::user()->can('Create Product')) {
            $categories = Category::where('created_by', $user_id)->pluck('name', 'id');
            $categories->prepend(__('Select Category'), '');
               
         $categories_all = Category::all();
            $brands = Brand::where('created_by', $user_id)->pluck('name', 'id');
            $brands->prepend(__('Select Brand'), '');

            $units = Unit::where('created_by', $user_id)->pluck('name', 'id');
            $units->prepend(__('Select Unit'), '');
            $unit = Unit::where('created_by', $user_id)->get();
            $taxes = Tax::where('created_by', $user_id)->pluck('name', 'id');
            $taxes->prepend(__('Apply Tax'), '');

            return view('products.create', compact('categories', 'brands', 'units', 'taxes','categories_all','unit'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request)
    {
        if (Auth::user()->can('Create Product')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100|unique:products,name,NULL,id,created_by,' . Auth::user()->getCreatedBy(),
                    'sku' => 'nullable|regex:/[\-]+/i',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $product                 = new Product();
            $product->name           = $request->name;
            $product->purchase_price = (float)$request->purchase_price;
            $product->sale_price     = (float)$request->sale_price;
            $product->sku            = $request->sku;
            $product->description    = $request->description;
            $product->sub_cat       = $request->sub_cat;
            $product->cannabis_weight       = $request->cannabis_weight;
            $product->net_product_weight       = $request->net_product_weight;
            $product->cannabis_volume       = $request->cannabis_volume;
            
            
            $product->thc       = $request->thc;
            $product->thc_min       = $request->thc_min;
            $product->thc_max       = $request->thc_max;

            $product->cbd       = $request->cbd;
            $product->cbd_min       = $request->cbd_min;
            $product->cbd_max       = $request->cbd_max;

            
            
            


            if (!empty($request->input('category_id'))) {
                $product->category_id = $request->category_id;
            }
           
            if (!empty($request->input('brand_id'))) {
                $product->brand_id = $request->brand_id;
            }
            if (!empty($request->input('tax_id'))) {
                $product->tax_id = $request->tax_id;
            }
            if (!empty($request->input('unit_id'))) {
                $product->unit_id = $request->unit_id;
            }
            $product->product_type = 0;
            $product->slug         = Str::slug($request->name, '-');
            $product->created_by   = Auth::user()->getCreatedBy();

            if ($request->hasFile('image')) {

                $validator = Validator::make(
                    $request->all(),
                    [
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
                    ]
                );

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }

                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $filenameWithExt . '_' . time() . '.' . $extension;
                // $filepath        = $request->file('image')->storeAs('productimages', $fileNameToStore);
                //
                
                $request->image->move(public_path('/img/productimg'), $fileNameToStore);
               $product->image=$fileNameToStore;
                
                $dir        = 'productimages/';
                //$path = Utility::upload_file($request,'image',$fileNameToStore,$dir,[]);
                
                // if($path['flag'] == 1){
                //     $url = $path['url'];
                //     $product->image  = $url;
                // }else{
                //     return redirect()->back()->with('error', __($path['msg']));
                // }
            }

            
            $product->save();

            return redirect()->route('products.index')->with('success', __('Product added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Product $product)
    {
        return redirect()->back()->with('error', __('Permission denied.'));
    }

    public function edit(Product $product)
    {
        $user_id = Auth::user()->getCreatedBy();
        if (Auth::user()->can('Edit Product')) {
            $categories = Category::where('created_by', $user_id)->pluck('name', 'id');
            $categories->prepend(__('Select Category'), '');

            $categories_all = Category::all();

            $brands = Brand::where('created_by', $user_id)->pluck('name', 'id');
            $brands->prepend(__('Select Brand'), '');

            $units = Unit::where('created_by', $user_id)->pluck('name', 'id');
            $units->prepend(__('Select Unit'), '');
            $unit = Unit::where('created_by', $user_id)->get();

            $taxes = Tax::where('created_by', $user_id)->pluck('name', 'id');
            $taxes->prepend(__('Apply Tax'), '');
           
            $branches=Branch::where('created_by',  $user_id)->get();

            return view('products.edit', compact('product', 'categories', 'brands', 'units', 'taxes','unit','categories_all','branches'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Product $product)
    {
        if (Auth::user()->can('Edit Product')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100|unique:products,name,' . $product->id . ',id,created_by,' . Auth::user()->getCreatedBy(),
                    'sku' => 'nullable|regex:/[\-]+/i',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $product->name           = $request->name;
            $product->purchase_price = $request->purchase_price;
            $product->sale_price     = $request->sale_price;
            $product->sku            = $request->sku;
            $product->description    = $request->description;
            $product->sub_cat            = $request->sub_cat;


            $product->cannabis_weight       = $request->cannabis_weight;
            $product->net_product_weight       = $request->net_product_weight;
            $product->cannabis_volume       = $request->cannabis_volume;
            
            
            $product->thc       = $request->thc;
            $product->thc_min       = $request->thc_min;
            $product->thc_max       = $request->thc_max;

            $product->cbd       = $request->cbd;
            $product->cbd_min       = $request->cbd_min;
            $product->cbd_max       = $request->cbd_max;

            if (!empty($request->input('category_id'))) {
                $product->category_id = $request->category_id;
            }
            if (!empty($request->input('brand_id'))) {
                $product->brand_id = $request->brand_id;
            }
            if (!empty($request->input('tax_id'))) {
                $product->tax_id = $request->tax_id;
            }
            if (!empty($request->input('unit_id'))) {
                $product->unit_id = $request->unit_id;
            }
            $product->slug = Str::slug($request->name, '-');

            $oldfilepath = $product->image;

            if ($request->imgstatus == 1) {
                if (asset(Storage::exists($oldfilepath))) {
                    $product->image = '';
                    asset(Storage::delete($oldfilepath));
                }
            }
            if ($request->hasFile('image')) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
                    ]
                );

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }

                if (asset(Storage::exists($oldfilepath))) {
                    asset(Storage::delete($oldfilepath));
                }

                $filenameWithExt = $request->file('image')->getClientOriginalName();
                $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension       = $request->file('image')->getClientOriginalExtension();
                $fileNameToStore = $filenameWithExt . '_' . time() . '.' . $extension;
                // $filepath        = $request->file('image')->storeAs('productimages', $fileNameToStore);
                $product->image  = $fileNameToStore;
                $request->image->move(public_path('/img/productimg'), $fileNameToStore);
                // $dir        = 'productimages/';
                // $path = Utility::upload_file($request,'image',$fileNameToStore,$dir,[]);
            
                // if($path['flag'] == 1){
                //     $url = $path['url'];
                //     $product->image  = $url;
                // }else{
                //     return redirect()->back()->with('error', __($path['msg']));
                // }
            }

            
            DB::table('inventories')->insert(
                ['product_id' => $product->id, 'branch_id' => $request->branch_id,'quantity'=>$request->quantity,'created_by'=>Auth::user()->getCreatedBy()]
            );
            $product->save();

            return redirect()->route('products.index')->with('success', __('Product updated successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Product $product)
    {
        if (Auth::user()->can('Delete Product')) {
            if (asset(Storage::exists($product->image))) {
                asset(Storage::delete($product->image));
            }
            $product->delete();

            return redirect()->route('products.index')->with('success', __('Product deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function searchProductsByName(Request $request)
    {
        $search = $request->search;

        if (Auth::user()->can('Manage Product') && $request->ajax() && $search != '') {
            $products = Product::getallproducts()->where('products.name', 'LIKE', "%{$search}%")->get();

            $items = [];
            foreach ($products as $key => $item) {
                $price = $item->sale_price != 0 ? $item->sale_price : 0;

                $tax = Product::where('products.id', $item->id)->leftJoin(
                    'taxes',
                    function ($join) {
                        $join->on('taxes.id', '=', 'products.tax_id')->where('taxes.created_by', '=', Auth::user()->getCreatedBy())->orWhereNull('products.tax_id');
                    }
                )->select(DB::Raw('IFNULL( `taxes`.`percentage` , 0 ) as percentage'))->first();

                $items[$key]['id']          = $item->id;
                $items[$key]['name']        = $item->name;
                $items[$key]['quantity']    = '1';
                $items[$key]['maxquantity'] = $item->getTotalProductQuantity() > 0 ? $item->getTotalProductQuantity() : '';
                $items[$key]['price']       = $price;
                $items[$key]['subtotal']    = $price + ($price * $tax->percentage) / 100;
                $items[$key]['tax']         = $tax->percentage;
            }

            return json_encode($items);
        }
    }

    public function searchProducts(Request $request)
    {
        $lastsegment = $request->session_key;

        if (Auth::user()->can('Manage Product') && $request->ajax() && isset($lastsegment) && !empty($lastsegment)) {
            $output = "";
            if ($request->cat_id !== '' && $request->search == '') {
                $products = Product::getallproducts()->where('category_id', $request->cat_id)->get();
            } else {
                $products = Product::getallproducts()->where('products.name', 'LIKE', "%{$request->search}%")->orWhere('category_id', $request->cat_id)->get();

                // $products = Product::getallproducts()->where('products.name', 'LIKE', "%{request->search}%")
                //     ->where(function ($q) use ($request) {
                //         $q->orWhere('category_id', $request->cat_id);
                //     })
                //     ->get();
            }
            if ($products) {
                foreach ($products as $key => $product) {
                    $image_url = (!empty($product->image) && Storage::exists($product->image)) ? $product->image : 'logo/placeholder.png';
                    if ($request->session_key == 'purchases') {
                        $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
                    } else if ($request->session_key == 'sales') {
                        $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
                    } else {
                        $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
                    }

                    $output .= '
                           
                              <div class="col-lg-4 col-md-4 col-sm-3 col-xs-4 col-12">
                              <div class="tab-pane fade show active toacart w-100" data-url="' . url('add-to-cart/' . $product->id . '/' . $lastsegment) .'">
                                  <div class="position-relative card">
                                      <img alt="Image placeholder" src="' . url("/public/img/productimg/",$product->image) . '" class="card-image avatar shadow hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                      <div class="p-0 custom-card-body card-body d-flex ">
                                          <div class="card-body my-2 p-2 text-left card-bottom-content">
                                              <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                              <small class="badge bg-primary mb-0 mt-2">' . Auth::user()->priceFormat($productprice) . '</small>

                                              <small class="top-badge badge bg-danger mb-0">'. $product->quantity .'</small>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                           
                    ';



            
                }

                return Response($output);
            } else {
                return Response(__('No result found'));
            }
        }
    }

    public function addToCart(Request $request, $id, $session_key)
    {
        if (Auth::user()->can('Manage Product') && $request->ajax()) {
            $product = Product::find($id);

            $productquantity = 0;

            if ($product) {
                $productquantity = $product->getTotalProductQuantity();
            }

            if (!$product || ($session_key == 'sales' && $productquantity == 0)) {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $productname = $product->name;
            if ($session_key == 'purchases') {

                $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
            } else if ($session_key == 'sales') {

                $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
            } else {

                $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
            }

            $originalquantity = (int)$productquantity;

            $tax = Product::where('products.id', $id)->leftJoin(
                'taxes',
                function ($join) {
                    $join->on('taxes.id', '=', 'products.tax_id')->where('taxes.created_by', '=', Auth::user()->getCreatedBy())->orWhereNull('products.tax_id');
                }
            )->select(DB::Raw('IFNULL( `taxes`.`percentage` , 0 ) as percentage'))->first();

            $producttax = $tax->percentage;

            $tax = ($productprice * $producttax) / 100;

            $subtotal        = $productprice + $tax;
            $cart            = session()->get($session_key);
            $image_url       = (!empty($product->image) && Storage::exists($product->image)) ? $product->image : 'logo/placeholder.png';
            $model_delete_id = 'delete-form-' . $id;

            $carthtml = '';

            $carthtml .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                                <td class="col-sm-2">
                                    <img alt="Image placeholder" src="' . url("/public/img/productimg/",$product->image). '" class="card-image avatar rounded-circle shadow hover-shadow-lg">
                                </td>

                                <td class="col-sm-2">
                                    <span class="name">' . $productname . '</span>
                                </td>

                              

                                <td class="col-sm-2">
                                    <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '">
                                        <input type="button" value="+" class="plus">
                                    </span>
                                </td>
                `

                                <td class="col-sm-2">
                                    <span class="tax">' . $producttax . '%</span>
                                </td>

                                <td class="col-sm-2">
                                    <span class="price">' . Auth::user()->priceFormat($productprice) . '</span>
                                </td>

                                <td class="col-sm-2">
                                    <span class="subtotal">' . Auth::user()->priceFormat($subtotal) . '</span>
                                </td>

                                <td class="col-sm-2">
                                    <div class="col-sm-2 mt-2">
                                        <a href="#" class="action-btn bg-danger bs-pass-para" data-confirm="' . __("Are You Sure?") . '" data-text="' . __("This action can not be undone. Do you want to continue?") . '" data-confirm-yes=' . $model_delete_id . ' title="' . __('Delete') . '}" data-id="' . $id . '" title="' . __('Delete') . '"   >
                                        <span class=""><i class="ti ti-trash btn btn-sm text-white"></i></span> 
                                        </a>
                                        <form method="post" action="' . url('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="_token" type="hidden" value="' . csrf_token() . '">
                                            <input type="hidden" name="session_key" value="' . $session_key . '">
                                            <input type="hidden" name="id" value="' . $id . '">
                                        </form>


                                    </div>
                                </td>
                            </tr>';



            // if cart is empty then this the first product
            if (!$cart) {
                $cart = [
                    $id => [
                        "name" => $productname,
                        "quantity" => 1,
                        "price" => $productprice,
                        "id" => $id,
                        "tax" => $producttax,
                        "subtotal" => $subtotal,
                        "originalquantity" => $originalquantity,
                    ],
                ];

                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'sales') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __(' added to cart successfully!'),
                        'product' => $cart[$id],
                        'carthtml' => $carthtml,
                    ]
                );
            }

            // if cart not empty then check if this product exist then increment quantity
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                $cart[$id]['id'] = $id;

                $subtotal = $cart[$id]["price"] * $cart[$id]["quantity"];
                $tax      = ($subtotal * $cart[$id]["tax"]) / 100;

                $cart[$id]["subtotal"]         = $subtotal + $tax;
                $cart[$id]["originalquantity"] = $originalquantity;

                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'sales') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __(' added to cart successfully!'),
                        'product' => $cart[$id],
                        'carttotal' => $cart,
                    ]
                );
            }

            // if item not exist in cart then add to cart with quantity = 1
            $cart[$id] = [
                "name" => $productname,
                "quantity" => 1,
                "price" => $productprice,
                "tax" => $producttax,
                "subtotal" => $subtotal,
                "id" => $id,
                "originalquantity" => $originalquantity,
            ];

            if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'sales') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'status' => 'Success',
                    'success' => $productname . __(' added to cart successfully!'),
                    'product' => $cart[$id],
                    'carthtml' => $carthtml,
                    'carttotal' => $cart,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

public function orderPurchase(Request $request, $id){
    $product = Product::find($id);
    
    $carthtml = '';
     $carthtml1 = '';
  $carthtml .=  '<tr data-product-id="' . $id . '" id="product-id-' . $id . '"><td scope="row">
                                        <a href="#"><span>' .  $product->name . '</span></a>
                                    </td>
                                    <td><input type="text" class="form-control" name="ordered" value="1" id=""></td>
                                    <td><input type="text" class="form-control" name="received" id=""></td>
                                    <td><input type="text" class="form-control" name="received" value="$'.$product->sale_price.'" id="" placeholder=""></td>
                                    <td><input type="text" class="form-control" name="received" id="" placeholder="$23.86" value="$'.$product->sale_price.'"></td>
                                    <td><textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea></td>
                                    <td><button type="button">X</button></td>
                                </tr>';
            $carthtml1 .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                                <td class="col-sm-2">
                                    <img alt="Image placeholder" src="' . url("/public/img/productimg/",$product->image). '" class="card-image avatar rounded-circle shadow hover-shadow-lg">
                                </td>

                                <td class="col-sm-2">
                                    <span class="name">' .  $product->name . '</span>
                                </td>

                              

                                <td class="col-sm-2">
                                    <span class="quantity buttons_added">
                                        <input type="button" value="-" class="minus">
                                        <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '">
                                        <input type="button" value="+" class="plus">
                                    </span>
                                </td>
                                
                            </tr>';

return view('purchases.create',compact('carthtml','product'));
    
}





    public function updateCart(Request $request)
    {
        $id          = $request->id;
        $quantity    = $request->quantity;
        $session_key = $request->session_key;


        if (Auth::user()->can('Manage Product') && $request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);



            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if ($quantity) {

                $cart[$id]["quantity"] = $quantity;

                $producttax            = $cart[$id]["tax"];
                $productprice          = $cart[$id]["price"];

                $subtotal = $productprice * $quantity;
                $tax      = ($subtotal * $producttax) / 100;

                $cart[$id]["subtotal"] = $subtotal + $tax;
            }

            if ($cart[$id]["originalquantity"] < $cart[$id]['quantity'] && $session_key == 'sales') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function removeFromCart(Request $request)
    {
        $id          = $request->id;
        $session_key = $request->session_key;
        if (Auth::user()->can('Manage Product') && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }

            return redirect()->back()->with('success', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }

    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;

        if (Auth::user()->can('Manage Product') && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0) {
                session()->forget($session_key);
            }

            return redirect()->back()->with('success', __('Cart is empty!'));
        } else {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));
        }
    }
    
    
    public function export()
    {
        $name = 'Product_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }

    public function importFile(){
        return view('products.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt,xlsx',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        
        $products = (new ProductImport())->toArray(request()->file('file'))[0];

        $totalProduct = count($products) - 1;
        $errorArray    = [];
        for ($i = 1; $i <= count($products) - 1; $i++) {
            $productData =$products[$i];
            
            $product                 = new Product();
            $product->name           = $productData[0];
            $product->sku            = $productData[1];
            $product->purchase_price = (float)$productData[2];
            $product->sale_price     = (float)$productData[3];
            $product->description    = $productData[4];
            $product->quantity       = $productData[5];
            $product->tax_id         = Tax::tax_id($productData[6]);
            $product->unit_id        = Unit::unit_id($productData[7]);
            $product->category_id    = Category::category_id($productData[8]);
            $product->brand_id       = Brand::brand_id($productData[9]);;
            $product->sub_cat        = $productData[10];
            $product->cannabis_weight       = 0;
            $product->net_product_weight    = 0;
            $product->cannabis_volume       = 0;           
            $product->thc                   = 0;
            $product->thc_min               = 0;
            $product->thc_max               = 0;
            $product->cbd                   = 0;
            $product->cbd_min               = 0;
            $product->cbd_max               = 0;
            $product->product_type          = 0;
            $product->image                 = 'placeholder.png';
            
            $product->slug         = Str::slug($productData[0], '-');
            $product->created_by   = Auth::user()->getCreatedBy();
            if (empty($product)) {
                $errorArray[] = $product;
            } else {
                $product->save();
            }
        }
        $errorRecord = [];
        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
    
    public function ajaxOCSApi(Request $request){
     
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
            
            
            $url = "https://apim-posdata-uat-cencan-001.azure-api.net/func-inventory-position-uat-cencan-001/RetailerItemCatalogueHttpTrigger?pageNumber=10";
            $curl = curl_init($url);
            
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            # Request headers
            $headers = array(
            'Authorization: '.$body['access_token'],
            "Cache-Control: no-cache",);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $resp = curl_exec($curl);
            curl_close($curl);
            $json_val= json_decode($resp);
            $all_product =$json_val->itemList;

            $output = "";
            $keyword=$request->search;

            foreach($all_product as $key=>$product){

                $string = $product->productName;

             if(preg_match("/{$keyword}/i",  $string)) {
                   $output .= ' <form action="'.route('products.import.ocs').'" method="POST" class="search-form"><input type="hidden" name="_token" value="'.$request->csrf_token.'"><input type="hidden" name="_method" value="post"><div class="row"><div class="col-md-2">
                   <img src="/uploads/logo/placeholder.png" alt="" style="width: 100px;">
                 </div>  
                 <div class="col-md-8">
                         <a href="#">
                             <span class="text-success">'.$string.'</span><br>
                         </a>  
                         <span class="text-dark">'.$product->SKU.'</span><br>
                         <span class="text-dark">'.$product->itemBarcode.'</span><br>
                         <span class="text-dark">'.$product->brand.'</span><br>
                         <span class="text-dark">'.$product->subCategory.'</span>
                         <input type="hidden" name="name" id="name" value="'.$string.'" class="search-box">
                         <input type="hidden" name="sku" id="SKU" value="'.$product->SKU.'" class="search-box">
                         <input type="hidden" name="itemBarcode" id="itemBarcode" value="'.$product->itemBarcode.'" class="search-box">
                         <input type="hidden" name="brand" id="brand" value="'.$product->brand.'" class="search-box">
                         <input type="hidden" name="subCategory" id="subCategory" value="'.$product->subCategory.'" class="search-box">
                         <input type="hidden" name="category" id="category" value="'.$product->category.'" class="search-box">

                         <input type="hidden" name="thc_min" id="thc_min" value="'.$product->minTHCPercent.'" class="search-box">
                         <input type="hidden" name="thc_max" id="thc_max" value="'.$product->maxTHCPercent.'" class="search-box">
                         <input type="hidden" name="cbd_min" id="cbd_min" value="'.$product->minCBDPercent.'" class="search-box">
                         <input type="hidden" name="cbd_max" id="cbd_max" value="'.$product->maxCBDPercent.'" class="search-box">


                     </div>
                     <div class="col-md-2 pt-4">
                         <input type="submit" value="Add" class="form-control btn btn-primary" name="add_product">
                     </div>
                 </div>
                 </form>';
            }
            }
                return Response($output);
            
            

        
    }
    
   public function search($name)
    {
        $result = Product::where('name', 'LIKE', '%'. $name. '%')->get();
        if(count($result)){
         return Response()->json($result);
        }
        else
        {
        return response()->json(['Result' => 'No Data not found'], 404);
      }
    }
    public function importOcsProduct(Request $request){

        $user_id = Auth::user()->getCreatedBy();

            $product                 = new Product();
            $category                 = new Category();
            $product->name           = $request->name;
            $product->purchase_price = (float)0.00;
            $product->sale_price     = (float)0.00;
            $product->sku            = strtoupper(str_replace("_","-",$request->sku));
            $product->sub_cat       = $request->subCategory;
           
            $product->thc_min       = $request->thc_min;
            $product->thc_max       = $request->thc_max;

            
            $product->cbd_min       = $request->cbd_min;
            $product->cbd_max       = $request->cbd_max;
           
            
            
            


            $categories = Category::where('name',$request->category)->get();
            if(count($categories) !=0){
                    $category->name=$request->category;
                    $category->slug=Str::slug($request->category, '-');
                    $category->sub_cat=$request->subCategory;
                    $category->compliance=$request->category;
                    $category->created_by=$user_id;
                    $category->save();
                    $product->category_id = $category->id;
            }
           
       
                $brands = new Brand();
                $brand = Brand::where('name',$request->brand)->get();
                if(count($brand) !=0){
                    $brands->name=$request->brand;
                    $brands->slug=Str::slug($request->brand, '-');
                    $brands->created_by=$user_id;
                    $brands->save();
                    $product->brand_id =$brands->id;
                }

           
            $product->product_type = 0;
            $product->slug         = Str::slug($request->name, '-');
            $product->created_by   = Auth::user()->getCreatedBy();


                

                
                $fileNameToStore ='placeholder.png';
                // $filepath        = $request->file('image')->storeAs('productimages', $fileNameToStore);
                //
                
               $product->image=$fileNameToStore;
                
                $dir        = 'productimages/';
                //$path = Utility::upload_file($request,'image',$fileNameToStore,$dir,[]);
                
                // if($path['flag'] == 1){
                //     $url = $path['url'];
                //     $product->image  = $url;
                // }else{
                //     return redirect()->back()->with('error', __($path['msg']));
                // }
            

            $product->save();

            return redirect()->route('products.index')->with('success', __('Product added successfully.'));
        
    }


    
}