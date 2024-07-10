<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        // $cart = session()->get('cart', []);
        // return view('cart.index', compact('cart'));
        $cartd=Cart::where('user_id',Auth::id())->get();
        return view('cart.index',compact('cartd'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $cartItem = Cart::where('user_id', $request->user_id)
        ->where('product_id', $request->product_id)
        ->first();  

              if ($cartItem) {
          $cartItem->quantity += 1;
            $cartItem->save();
                } else {
              $cdata = [
               'user_id' => $request->user_id,
              'product_id' => $request->product_id,
                'quantity' => 1,];
              Cart::create($cdata);
} 
        return redirect('/cart');
    //     $productId = $request->input('product_id');
    //     $product = Product::findOrFail($productId);
    //     $cart = session()->get('cart', []);

    //     // Check if product is already in cart
    //     if (isset($cart[$productId])) {
    //         $cart[$productId]['quantity']++;
    //     } else {
    //         $cart[$productId] = [
    //             "name" => $product->name,
    //             "quantity" => 1,
    //             "price" => $product->price,
    //             "net_price" => $product->net_price,
    //             "image" => $product->media->first()->file_path ?? 'imgnotavl.png'
    //         ];
    //     }

    //     session()->put('cart', $cart);
        // return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request)
    {
        dd($request);
        // if($request->id && $request->quantity) {
        //     $cart = session()->get('cart');

        //     $cart[$request->id]['quantity'] = $request->quantity;

        //     session()->put('cart', $cart);

        //     return redirect()->back()->with('success', 'Cart updated successfully');
        // }
    }
    public function show(Request $request){
         
        
            $cartItem = Cart::where('id',$request->id)->first();  
                  if ($cartItem) {
                    if($request->quantity==0)
                    {
                        $cartItem->delete();
                    }else{
                        $cartItem->quantity = $request->quantity;
                        $cartItem->save();
                    } 
    
                return redirect()->back()->with('success', 'Cart updated successfully');
                  }
            
        return "hello";
    }
    public function destroy(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            return redirect()->route('cart.index')->with('success', 'Product removed successfully!');
        }
    }
    public function ok(){
        return "done";
    }

}
