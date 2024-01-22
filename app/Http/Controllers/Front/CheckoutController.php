<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Cart;
use Illuminate\Support\Facades\DB;
use Session;

class CheckoutController extends Controller
{
    // Checkout page
    public function Checkout()
    {

        if (!Auth::check()) {

            $notification = array('messege' => 'Login Your Account!', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }

        $content = Cart::content();
        return view('frontend.cart.checkout', compact('content'));
    }


    // Coupon Apply
    public function  ApplyCoupon(Request $request)
    {

        $check = DB::table('coupons')->where('coupon_code', $request->coupon)->first();

        if ($check) {
            //coupon Exist
            if (date('Y-m-d', strtotime(date('Y-m-d'))) <= date('Y-m-d', strtotime($check->valid_date))) {

                session::put('coupon', [
                    'name' => $check->coupon_code,
                    'discount' => $check->coupon_amount,
                    'after_discount' => Cart::subtotal() - $check->coupon_amount
                ]);

                $notification = array('messege' => 'Coupon Applied!', 'alert-type' => 'success');
                return redirect()->back()->with($notification);
            } else {

                $notification = array('messege' => 'Expired Coupon Code!', 'alert-type' => 'error');
                return redirect()->back()->with($notification);
            }
        } else {

            $notification = array('messege' => 'Invalid Coupon Code! Try Again', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        };
    }


    // Remove Coupon
    public function RemoveCoupon()
    {
        Session::forget('coupon');

        $notification = array('messege' => 'Coupon Removed!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
