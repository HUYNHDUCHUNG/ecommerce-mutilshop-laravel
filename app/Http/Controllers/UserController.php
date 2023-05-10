<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Category;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use App\Models\Ward;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use function PHPSTORM_META\type;

class UserController extends Controller
{

    public function search_products(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }
        $category = Category::all();
        //$product = Product::where('product_name', 'LIKE', '%' . $request->keyword . '%')->get();
        $product = Product::where('product_name', 'LIKE', '%' . $request->keyword . '%')->orWhere('product_brand', 'LIKE', '%' . $request->keyword . '%')->get();
        return view('client.product', compact('category', 'product', 'cart_qty'));
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
                                    <h5>" . number_format($item->product_price) . "</h5><h6 class='text-muted ml-2'><del>" . number_format($item->product_price) . " </del></h6>
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
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        $product_featured = Product::where('product_featured', 1)->get();
        $product_recent = Product::where('created_at', '>=', Carbon::now()->subDays(15))
            ->orderBy('created_at', 'desc')
            ->get();
        return view('client.home', compact('category', 'product_featured', 'product_recent', 'cart_qty'));
    }
    public function product(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        $product = Product::all();
        return view('client.product', compact('category', 'product', 'cart_qty'));
    }

    public function product_detail(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();

        $product = Product::find($request->id);
        $img = $product->productImgs;
        $textSize = $product->product_size;
        $textColor = $product->product_color;
        $size = explode(",", $textSize);
        $color = explode(",", $textColor);
        return view('client.product-detail', compact('category', 'product', 'img', 'cart_qty', 'size', 'color'));
    }
    public function cart(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $cartDetails = Cart::where('user_id', session()->get('USER_ID'))->first()->cartDetails()->latest()->get();
        $img = [];
        $nameProduct = [];
        $total_all = 0;
        foreach ($cartDetails as $item) {
            $model = Product::find($item->product_id);
            $img[] = $model->productImgs['0']->img_name;
            $nameProduct[] = $model->product_name;
            $total_all += $item->price * $item->quantity;
        }
        $category = Category::all();
        return view('client.cart', compact('category', 'cartDetails', 'img', 'nameProduct', 'cart_qty', 'total_all'));
    }
    public function checkout(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $cartDetails = Cart::where('user_id', session()->get('USER_ID'))->first()->cartDetails()->latest()->get();
        $img = [];
        $nameProduct = [];
        $total_all = 0; // tong gia tat ca san pham
        $quantity_all = 0;
        foreach ($cartDetails as $item) {
            $model = Product::find($item->product_id);
            $model->product_quantity -= $item->quantity;
            $model->update();
            $img[] = $model->productImgs['0']->img_name;
            $nameProduct[] = $model->product_name;
            $total_all += $item->price * $item->quantity;
            $quantity_all += $item->quantity;
        }

        $category = Category::all();
        $user = User::find($request->session()->get('USER_ID'));
        $province = Province::all();
        $district = District::all();
        $ward = Ward::all();
        return view('client.checkout', compact('category', 'user', 'cart_qty', 'province', 'cartDetails', 'img', 'nameProduct', 'total_all', 'quantity_all', 'district', 'ward'));
    }

    public function thankyou(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        return view('client.thankyou', compact('category', 'cart_qty'));
    }

    public function order(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        $status = OrderStatus::all();
        $order = Order::where('user_id', $request->session()->get('USER_ID'))->latest()->get();
        return view('client.order', compact('order', 'category', 'cart_qty', 'status'));
    }
    public function order_filter(Request $request)
    {

        if ($request->status == 'all') {
            $order = Order::where('user_id', $request->session()->get('USER_ID'))->latest()->get();
        } else {
            $order = Order::where('user_id', $request->session()->get('USER_ID'))->where('status', $request->status)->latest()->get();
        }
        $html = '';

        foreach ($order as $item) {
            $html .= "<tr>
                <th scope='row'>#" . $item->code . " </th>
                <td>" . $item->fullname . "</td>
                <td>" . $item->phonenumber . "</td>
                <td>" . $item->address . "</td>
                <td>" . $item->orderStatus->name . "</td>
                <td>" . $item->created_at . "</td>
              </tr>";
        }
        return $html;
    }

    public function profile(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        $province = Province::all();
        $district = District::all();
        $ward = Ward::all();
        $user = User::find($request->session()->get('USER_ID'));
        return view('client.profile', compact('category', 'cart_qty', 'user', 'province', 'district', 'ward'));
    }

    public function edit_profile(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'phonenumber' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'specific' => 'required',

        ]);

        $model = User::find($request->session()->get('USER_ID'));
        $model->name = $request->fullname;
        $model->phonenumber = $request->phonenumber;
        $model->province = $request->province;
        $model->district = $request->district;
        $model->ward = $request->ward;
        $model->address = $request->specific;
        $model->update();

        return redirect()->route('user.profile');
    }

    public function district(Request $request)
    {
        $district = District::where('province_id', $request->id_province)->get();
        $html = '<option selected>------Choose District------</option>';
        foreach ($district as $item) {
            $html .= '<option value= "' . $item->district_id . '" > ' . $item->name . '</option>';
        }
        return $html;
    }

    public function ward(Request $request)
    {
        $ward = Ward::where('district_id', $request->id_district)->get();
        $html = '<option selected>------Choose Ward------</option>';
        foreach ($ward as $item) {
            $html .= '<option value= "' . $item->wards_id . '" > ' . $item->name . '</option>';
        }
        return $html;
    }

    public function login(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }

        $category = Category::all();
        return view('client.account.login', compact('category', 'cart_qty'));
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

    public function register(Request $request)
    {
        $cart_qty = 0;
        if ($request->session()->has('USER_ID')) {
            if (Cart::where('user_id', $request->session()->get('USER_ID'))->first()) {
                $cart_qty = Cart::where('user_id', $request->session()->get('USER_ID'))->first()->cartDetails->count();
            } else {
                $cart_qty = 0;
            }
        }
        $category = Category::all();
        return view('client.account.register', compact('category', 'cart_qty'));
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

            $request->session()->flash('success', 'Successfully Register');
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
