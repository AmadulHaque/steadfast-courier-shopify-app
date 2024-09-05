<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Osiset\ShopifyApp\Storage\Models\Plan;

class WelcomeController extends Controller
{
    public function welcome()
    {
        // Get the authenticated user's ID
        $userId = auth()->user()->id;
        
        // Capture the search input
        $search = request()->input('search');

        // Query to fetch orders with optional search functionality
        $orders = Order::where('user_id', $userId)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('orderNumber', 'like', "%{$search}%")
                      ->orWhere('steadFastId', 'like', "%{$search}%")
                      ->orWhere('orderId', 'like', "%{$search}%");
                });
            })
            ->paginate(20);
    
        // Return JSON response if it's an AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'orders' => $orders->items(),
                'links' => $orders->links()->render(),
            ]);
        }
    
        // Return the view with the orders data
        return view('welcome', compact('orders'));
    }
    

    public function saveSettings(Request $request){

        $data= $request->all();

        $request->validate([
            'appStatus' => ['required'],
            'apiKey' => ['required', 'string'],
            'secretKey' => ['required', 'string'],
            'businessName' => ['nullable', 'string'],
            'businessAddress' => ['nullable', 'string'],
            'businessEmail' => ['nullable', 'email', 'string'],
            'businessNumber' => ['nullable', 'numeric'],
            'businessTerms' => ['nullable', 'string'],
        ]);

        if(is_string($data['businessLogo'])){   
            $request->validate([
                'businessLogo' => ['nullable', 'string'],
            ]);
        }

        if(!is_string($data['businessLogo'])){   
            $request->validate([
                'businessLogo' => ['nullable', 'image', 'mimes:jpg,png', 'max:1000'],
            ]);
        }

        if(isset($data['businessLogo']) && !is_string($data['businessLogo'])){
            $logoExtension= $data['businessLogo']->getClientOriginalExtension();
            $logoName= auth()->user()->id. '-'. uniqid() . '.'. $logoExtension;
            Storage::putFileAs('businessLogo', $data['businessLogo'], $logoName);
            $data['businessLogo'] = $logoName;

            if(isset(auth()->user()->businessLogo)){
                Storage::delete('businessLogo/'.auth()->user()->businessLogo);
            }
        }
        $data['appStatus']= $data['appStatus'] == 'true' ? 1 : 0;
        try {
            User::find(auth()->user()->id)->update($data);
            return ['status'=>'success', 'userData'=> User::find(auth()->user()->id)];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // public function plans()
    // {
    //     $plans = Plan::all();
    //     return view('plans',compact('plans'));
    // }

    public function privacyPolicy(){
        return view('privacy');
    }
}
