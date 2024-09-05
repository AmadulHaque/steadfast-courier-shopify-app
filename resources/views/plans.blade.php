@extends('layouts.shopify')

@section('content')

    <div class="max-w-5xl mx-auto p-4">
        <div class="mb-6">
            <a href="{{ URL::tokenRoute('home') }}" class="font-semibold">Home</a>
        </div>

        @if (!optional(auth()->user()->plan)->id)
            <p class="text-center mb-6 font-semibold text-red-700">Please select a plan to use this app.</p>
        @endif

        <div class="flex flex-col gap-6 sm:flex-row">
            @foreach ($plans as $plan)

            <div class="rounded-lg shadow-lg max-w-2xl bg-white p-6 w-full sm:W-[33.33%]">
                <h2 class="font-semibold text-3xl">{{$plan->name}}</h2>
                <div>
                    <h3 class="text-2xl">
                        <del class="text-lg text-red-700">${{number_format($plan->price+5, 2)}}</del>
                         ${{number_format($plan->price, 2)}}<span class="text-lg">/Month</span>
                    </h3>
                    <p class="text-green-700 font-semibold">7 day free trial</p>
                </div>
                @if ($plan->name=='Basic')
                    <p>Limit of 10 discounts</p>
                @endif
                @if ($plan->name=='Premium')
                    <p>Limit of 100 discounts</p>
                @endif
                @if ($plan->name=='Enterprise')
                    <p>Limit of 500 discounts</p>
                @endif
                <div class="mt-6">
                    <a
                    href="{{ optional(auth()->user()->plan)->id == $plan->id ? '#' : route('billing', ['plan' => $plan->id, 'shop' => auth()->user()->name, 'host' => app('request')->input('host')]) }}"
                        
                    class="{{ optional(auth()->user()->plan)->id == $plan->id ? 'bg-gray-200 text-black cursor-default' : 'bg-green-700 hover:bg-green-800 text-white'}} rounded-md block text-center py-2 font-semibold"
                    >
                        {{ optional(auth()->user()->plan)->id == $plan->id ? 'Active' : 'Upgrade' }}
                    </a>
                </div>
            </div>
            @endforeach 
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
@endsection
