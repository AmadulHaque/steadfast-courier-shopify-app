<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Symfony\Component\HttpFoundation\Response;

class LimitCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $variantsCount = ProductVariant::whereHas('product', function ($q) {
            $q->where([
                'user_id' => auth()->user()->id,
            ]);
        })->count();

        $newCount = $variantsCount + count($request->variants);

        if(optional(auth()->user()->plan)->name=='Basic' && $newCount > 10 ){
            $msg= $this->msg(10, $variantsCount);
            return response()->json(['error' => 'Plan limit reached.'. $msg ]);
        }

        if(optional(auth()->user()->plan)->name=='Premium' && $newCount > 100 ){
            $msg= $this->msg(100, $variantsCount);
            return response()->json(['error' => 'Plan Limit Reached.'. $msg ]);
        }

        if(optional(auth()->user()->plan)->name=='Enterprise' && $newCount > 500){
            $msg= $this->msg(500, $variantsCount);
            return response()->json(['error' => 'Plan Limit Reached.'. $msg ]);
        }

        return $next($request);
    }

    function msg($limit, $variantsCount){
        $msg=' Please upgrade.';
        if($variantsCount < $limit){
            $available= $limit - $variantsCount;
        }
        if(isSet($available)){
           $msg= ' You can create only '. $available . ' more '. ($available>1 ? 'discounts.' : 'discount.');
        }
        return $msg;
    }
}

