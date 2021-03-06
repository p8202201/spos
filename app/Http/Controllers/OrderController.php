<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{

    public function index()
    {
        $orders = \App\Models\Order::all();
        $customers = \App\Models\Customer::all();
        $data = compact('orders','customers');
        return view('orders.index',$data);
    }
    
    public function new()
    {
        $products = Product::all();
        
        $cart = Cart::where('user_id',Auth::user()->id)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->save();
        }

        $items = $cart->cartItems;
        $total=0;
        foreach($items as $item){
            $total+=$item->product->price;
        }
        $data = compact('products','items','total');
        
        return view('orders.new',$data);

    }
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addItem ($productId){

        $cart = Cart::where('user_id',Auth::user()->id)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->save();
        }

        $cartItem  = new Cartitem();
        $cartItem->product_id=$productId;
        $cartItem->cart_id= $cart->id;
        $cartItem->save();

        return redirect('/orders/new');
    }

    public function removeItem($id){

        CartItem::destroy($id);
        return redirect('/orders/new');
    }
    
    public function create()
    {
        $cart = Cart::where('user_id',Auth::user()->id)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->user_id=Auth::user()->id;
            $cart->save();
        }
        
        $items = $cart->cartItems;
        $total=0;
        foreach($items as $item){
            $total+=$item->product->price;
        }
        
        $customers = \App\Models\Customer::all();;
        $products = Product::all();;
        $transits = \App\Models\Transit::all();;
        $now = Carbon::now(('Asia/Taipei'));
        $data = compact('customers','products','transits','now');
        
        return view('orders.create',$data,['items'=>$items,'total'=>$total]);
    }
    
    public function save(Request $request)
    {
        $method = $request->method();
        $order = new \App\Models\Order;
        $order->orderdate = $request['orderdate'];
        $order->custid = $request['custid'];
        $order->prodid = $request['prodid'];
        $order->fare = $request['fare'];
        $order->price = $request['price'];
        $order->paytime = $request['paytime'];
        $order->deliverytime = $request['deliverytime'];
        $order->transit = $request['transit'];
        $order->note = $request['note'];
        $order->save();
        
        return Redirect::to('orders');
    }

}
