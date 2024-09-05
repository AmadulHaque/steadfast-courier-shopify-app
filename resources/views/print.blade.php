<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Laralink">
    <!-- Site Title -->
    <title>SteadFast Courier LTD | Invoice</title>
    <link rel="stylesheet" href="{{ asset('print.css') }}">
</head>

<body class="invoice">
    <div class="tm_container">
        <div class="tm_invoice_wrap">
            <div class="tm_invoice tm_style1" id="tm_download_section">
                <div class="tm_invoice_in">
                    <div class="tm_invoice_head tm_align_center tm_mb20">
                        <div class="tm_invoice_left">
                            <div class="tm_logo">
                                @if (isset($user->businessLogo))
                                <img src="{{ asset('storage/businessLogo/'. $user->businessLogo)}}" alt="Logo">
                                @else
                                <img src="{{ asset('images/steadFast.png') }}" alt="Logo">
                                @endif
                            </div>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <div class="tm_primary_color tm_f30 tm_text_uppercase">Invoice</div>
                        </div>
                    </div>
                    <div class="tm_invoice_info tm_mb20">
                        <div class="tm_invoice_seperator"></div>
                        <div class="tm_invoice_info_list">
                            <p class="tm_invoice_number tm_m0">Invoice No: <b class="tm_primary_color">#{{ $order->orderNumber}}</b></p>
                            <p class="tm_invoice_date tm_m0">Date: <b class="tm_primary_color">{{$order->created_at->format('d-m-Y')}}</b></p>
                        </div>
                    </div>
                    <div class="tm_invoice_head tm_mb10">
                        <div class="tm_invoice_left">
                            <p class="tm_mb2"><b class="tm_primary_color">Invoice To:</b></p>
                            <p>
                               {{$order->name}}
                                <br>
                                {{$order->address}}
                                <br>
                                {{$order->email}}
                                <br>
                                {{$order->phone}}
                            </p>
                        </div>
                        <div class="tm_invoice_right tm_text_right">
                            <p class="tm_mb2"><b class="tm_primary_color">Pay To:</b></p>
                            <p>
                                {{$user->businessName}}
                                <br>
                                {{$user->businessAddress}}
                                <br>
                                {{$user->businessEmail}}
                                <br>
                                {{$user->businessNumber}}
                            </p>
                        </div>
                    </div>
                    <div class="consignment">
                        <div class="tm_padd_15_20 tm_round_border">
                            <div class="tm_mb10 tm_invoice_head tm_align_center">
                                <div class="tm_invoice_left">
                                    <p class="tm_mb3"><b class="tm_primary_color">For SteadFast Courier LTD</b></p>
                                </div>
                                <div class="tm_invoice_right tm_text_right invoice_img">
                                    <img src="{{ asset('images/steadFast.png') }}" alt="Logo">
                                </div>
                            </div>
                            <hr class="hr">
                            <div class="tm_invoice_head tm_mb10">
                                <div class="tm_invoice_left">
                                    <h5 class="tm_mb2"><b class="tm_primary_color">CN ID: #{{$order->steadFastId}}</b></h5>
                                </div>
                                <div class="tm_invoice_right tm_text_right">
                                    <h5 class="tm_mb2"><b class="tm_primary_color">COD Amount: &#2547;{{number_format($order->steadFastAmount,2)}}</b></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tm_table tm_style1 tm_mb30">
                        <div class="tm_round_border">
                            <div class="tm_table_responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="tm_width_3 tm_semi_bold tm_primary_color tm_gray_bg">Item</th>
                                            <th class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg">Price</th>
                                            <th class="tm_width_1 tm_semi_bold tm_primary_color tm_gray_bg">Qty</th>
                                            <th
                                                class="tm_width_2 tm_semi_bold tm_primary_color tm_gray_bg tm_text_right">
                                                Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td class="tm_width_3">{{$item->name}}</td>
                                            <td class="tm_width_2">&#2547;{{number_format($item->price,2)}}</td>
                                            <td class="tm_width_1">{{$item->quantity}}</td>
                                            <td class="tm_width_2 tm_text_right">&#2547;{{number_format($item->price * $item->quantity, 2)}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tm_invoice_footer">
                            <div class="tm_left_footer">
                                {{-- <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                                <p class="tm_m0">Credit Card - 236***********928 <br>Amount: &#2547; 998</p> --}}
                            </div>
                            <div class="tm_right_footer">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                                            <td
                                                class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">
                                                &#2547;{{number_format($subtotal, 2)}}</td>
                                        </tr>
                                        @if ($order->tax != '0.00')
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax</td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                                                +&#2547;{{number_format($order->tax,2)}}</td>
                                        </tr>
                                        @endif
                                        @if ($order->shipping != '0.00')
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Shipping</td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                                                +&#2547;{{number_format($order->shipping,2)}}</td>
                                        </tr>
                                        @endif

                                        @if ($order->discount != '0.00')
                                        <tr>
                                            <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Discount</td>
                                            <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">
                                                -&#2547;{{number_format($order->discount,2)}}</td>
                                        </tr>
                                        @endif
                                        
                                        <tr class="tm_border_top tm_border_bottom">
                                            <td class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color">Grand
                                                Total </td>
                                            <td
                                                class="tm_width_3 tm_border_top_0 tm_bold tm_f16 tm_primary_color tm_text_right">
                                                &#2547;{{number_format(($subtotal+$order->tax+$order->shipping)-$order->discount,2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tm_padd_15_20 tm_round_border">
                        <p class="tm_mb5"><b class="tm_primary_color">Terms & Conditions:</b></p>
                        <ul class="tm_m0 tm_note_list">
                            @foreach ($terms as $term)
                            <li>{{$term}}</li>
                            @endforeach
                        </ul>
                    </div><!-- .tm_note -->
                </div>
            </div>
            <div class="tm_invoice_btns tm_hide_print">
                <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
                    <span class="tm_btn_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                            <path
                                d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32"
                                fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none"
                                stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
                            <circle cx="392" cy="184" r="24" fill='currentColor' />
                        </svg>
                    </span>
                    <span class="tm_btn_text">Print</span>
                </a>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', ()=>window.print())
    </script>
</body>
</html>
