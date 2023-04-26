<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function search_products(Request $request)
    {
        $category = Category::all();
        //$product = Product::where('product_name', 'LIKE', '%' . $request->keyword . '%')->get();
        $product = Product::where('product_name', 'LIKE', '%' . $request->keyword . '%')->orWhere('product_brand', 'LIKE', '%' . $request->keyword . '%')->get();
        return view('client.product', compact('category', 'product'));
    }

    public function product_filter(Request $request)
    {
        if ($request->filter_min == 0 && $request->filter_max == 0) {
            $product = Product::all();
        } else {
            $product = Product::whereBetween('product_price', [$request->filter_min, $request->filter_max])->get();
        }
        $items = '';
        foreach ($product as $item) {
            $items .= "
            <div class='col-lg-4 col-md-6 col-sm-6 pb-1'>
            <div class='product-item bg-light mb-4'>
                            <div class='product-img position-relative overflow-hidden'>
                                <img class='img-fluid w-100' src='http://127.0.0.1:8000/storage/upload/" . $item->productImgs['0']->img_name . "' alt=''>
                                <div class='product-action'>
                                   
                                    <a class='btn btn-outline-dark btn-square' href=' /product-detail/" . $item->id . "'><i class='fa fa-search'></i></a>
                                </div>
                            </div>
                            <div class='text-center py-4'>
                                <a class='h6 text-decoration-none text-truncate' href=''>" . $item->product_name . "</a>
                                <div class='d-flex align-items-center justify-content-center mt-2'>
                                    <h5>" . $item->product_price . "</h5><h6 class='text-muted ml-2'><del>" . $item->product_price . " </del></h6>
                                </div>
                                <div class='d-flex align-items-center justify-content-center mb-1'>
                                    <small class='fa fa-star text-primary mr-1'></small>
                                    <small class='fa fa-star text-primary mr-1'></small>
                                    <small class='fa fa-star text-primary mr-1'></small>
                                    <small class='fa fa-star text-primary mr-1'></small>
                                    <small class='fa fa-star text-primary mr-1'></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                        </div>";
        }
        return $items;
    }

    public function index(Request $request)
    {

        // $cart = Cart::where('user_id',$request->session()->get('USER_ID'))->first()->cartDetails->count('items');
        $category = Category::all();
        $product = Product::all();
        // session()->put('category', $category);
        return view('client.home', compact('category', 'product'));
    }
    public function product()
    {
        $category = Category::all();
        $product = Product::all();
        return view('client.product', compact('category', 'product'));
    }

    public function product_detail(Request $request)
    {
        $category = Category::all();

        $product = Product::find($request->id);
        $img = $product->productImgs;
        return view('client.product-detail', compact('category', 'product', 'img'));
    }
    public function cart()
    {
        $cartDetails = Cart::where('user_id', session()->get('USER_ID'))->first()->cartDetails;
        $img = [];
        $nameProduct = [];
        foreach ($cartDetails as $item) {
            $model = Product::find($item->product_id);
            $img[] = $model->productImgs['0']->img_name;
            $nameProduct[] = $model->product_name;
        }
        $category = Category::all();
        return view('client.cart', compact('category', 'cartDetails', 'img', 'nameProduct'));
    }
    public function checkout()
    {
        $category = Category::all();
        return view('client.checkout', compact('category'));
    }

    public function login()
    {
        $category = Category::all();
        return view('client.account.login', compact('category'));
    }

    public function auth_login(Request $request)
    {
        $email = $request->post('email');
        $password = $request->post('password');

        $result = User::where(['email' => $email])->first();
        if (isset($result)) {
            if (Hash::check($request->post('password'), $result->password)) {
                $request->session()->put('USER_LOGIN', true);
                $request->session()->put('USER_ID', $result->id);
                $user = User::where('email', $email)->first();
                $request->session()->put('user', $user);
                return redirect()->route('home');
            } else {
                $request->session()->flash('error', 'Please enter a valid password');
                return redirect()->route('user.login');
            }
        } else {
            $request->session()->flash('error', 'Please enter a valid email address');
            return redirect()->route('user.login');
        }
    }

    public function register()
    {
        $category = Category::all();
        return view('client.account.register', compact('category'));
    }

    public function auth_register(Request $request)
    {

        $request->validate([
            'fullName' => 'required',
            'phoneNumber' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'rePassword' => 'required',
        ]);

        if ($request->password == $request->rePassword) {
            User::create([
                'name' => $request->fullName,
                'email' => $request->email,
                'phonenumber' => $request->phoneNumber,
                'password' => Hash::make($request->password),
            ]);
            return redirect()->route('user.login');
        } else {
            $request->session()->flash('error', 'password does not match');
            return redirect()->route('user.register');
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('home');
    }





    public function updatepassword()
    {
        $r = User::find('1');
        $r->password = Hash::make('12345');
        $r->save();
    }
}
