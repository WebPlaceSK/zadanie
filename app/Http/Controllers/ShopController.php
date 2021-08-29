<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\db\Categories;
use App\db\Products;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{


    public function getProducts(Request $request){
        if(!is_numeric($request->category_id))  $error[] = 'Category ID is invalid!';
        if(!is_numeric($request->company_id))  $error[] = 'Company ID is invalid!';
        if(is_numeric($request->order))  $error[] = '"Filtered by" is invalid!';
        if(isset($error)) return ['error' => $error];
        if($request->has('category_id') and $request->has('order') and $request->has('company_id')){
            if($request->order == 'price' or $request->order == 'name' or $request->order == 'o	stock '){
                $order = $request->order;
            }else{
                $order = 'id';
            }

            if (Cache::has('products_by_'.$request->category_id.'_'.$request->company_id.'_'.$order)) {
                $products = Cache::get('products_by_'.$request->category_id.'_'.$request->company_id.'_'.$order, function ($request,$order) {
                    return json_encode(Products::where([['categories_id', 'LIKE', '%'.$request->category_id.'%'],['company_id',$request->company_id]])->orderby($order , 'desc')->get());
                });
            }else{
                $products = Cache::get('products_by_'.$request->category_id.'_'.$request->company_id.'_'.$order, function () {
                    return json_encode(Products::get());
                });
            }
        }else{
            if (Cache::has('products')) {
                $products = Cache::get('products');
            }else{
                $products = Cache::get('products', function () {
                    return json_encode(Products::get());
                });
            }
        }

        return $products;
    }

    public function getProductById($id){
        if(!is_numeric($id))  return ['error' => 'Product ID is invalid!'];
        if(Products::where('productId',$id)->exists()){
            return json_encode(Products::where('productId',$id)->first());
        }else{
            return json_encode(['error' => 'Product not exist.']);
        }
    }

    public function getCategories(){
        return json_encode(Categories::get());
    }

    public function getCategoryById($id){
        if(!is_numeric($id))  return ['error' => 'Category ID is invalid!'];
        if(Categories::where('category_id',$id)->exists()){
            return json_encode(Categories::where('category_id',$id)->first());
        }else{
            return json_encode(['error' => 'Category not exist.']);
        }
    }

    public function getProductSearch($slug, Request $request){
        if(isset($request->type) and isset($request->in_stock_first)){ // price , name, stock
            if(Products::whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))->count() > 0){
                $products = Products::whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))
                    ->orderby('price','asc') // alebo desc, podla potreby
                    ->orderby('stock','asc') // alebo desc, podla potreby
                    ->orderby('name','desc') // alebo asc, podla potreby
                    ->get()->toarray();
            }else{
                $products = Products::where('name','like', $slug)->orwhere('description','like', $slug)->orwhere('company_name','like', $slug)
                    ->orderby('price','asc') // alebo desc, podla potreby
                    ->orderby('stock','asc') // alebo desc, podla potreby
                    ->orderby('name','desc') // alebo asc, podla potreby
                    ->get()->toarray();
            }
        }else{
            if(isset($slug)){
                if(Products::whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))->count() > 0){
                    $products = Products::whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))->get()->toarray();
                }else{
                    $products = Products::where('name','like', $slug)
                        ->orwhere('description','like', $slug)
                        ->orwhere('company_name','like', $slug)
                        ->get()->toarray();
                }
            }else{
                $products = ['error' => 'The search term was not found!'];
            }
        }
        return json_encode($products);
    }

    public function getProductSearchByCategories($cat_id, $slug){
        if(!is_numeric($cat_id))  return ['error' => 'Category ID is invalid!'];
        if(isset($cat_id) and isset($slug)){
            if(Products::where('categories_id','%'.$cat_id.'%')->whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))->count() > 0){
                $products = Products::where('categories_id','%'.$cat_id.'%')->whereRaw("MATCH(name, description, company_name) AGAINST(? IN BOOLEAN MODE)",array($slug))->get();
            }else{
                $products = Products::where('categories_id','%'.$cat_id.'%')->orwhere('name','like', $slug)->orwhere('description','like', $slug)->orwhere('company_name','like', $slug)->get();
            }
        }else{
            $products = ['error' => 'The search term was not found!'];
        }
        return json_encode($products);
    }

    //Vytvorte efektívnu pravidelnú synchronizaciou skladu a cien (price) a dostupnosti (stock) podľa sku produktu z externého zdroja
    //pouzil by som Scheduling pre vytvorenie samostatnej 'cron' ulohy, ktora by porovnala data ulozene v cache a z restAPI, v pripade
    // ze sa niektore data nebudu zhodovat tak sa spusti aktualizacia konktretnych produktov
}
