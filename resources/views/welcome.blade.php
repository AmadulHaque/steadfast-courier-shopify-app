@extends('layouts.shopify')

@section('js')
@endsection
@section('content')
    <div class="max-w-5xl m-auto p-6" x-data>
        {{-- TABS --}}
        <div
            class="inline-flex gap-4 flex-wrap [&>button]:bg-white [&>button]:rounded-lg [&>button]:px-6 [&>button]:py-1 [&>button]:font-medium [&>button]:text-black">
            <button class="hover:bg-gray-300" :class="$store.state.activeTab == 'dashboard' && '!bg-green-700 !text-white'"
                @click="$store.state.activeTab='dashboard'">Dashboard</button>
            <button class="hover:bg-gray-300" :class="$store.state.activeTab == 'settings' && '!bg-green-700 !text-white'"
                @click="$store.state.activeTab='settings'">Settings</button>
            <button class="hover:bg-gray-300" :class="$store.state.activeTab == 'orders' && '!bg-green-700 !text-white'"
                @click="$store.state.activeTab='orders'">Orders</button>
        </div>
        <div class="bg-white rounded-lg p-4 mt-4">
            {{-- DASHBOARD --}}
            <template x-if="$store.state.activeTab=='dashboard'">
                <div>
                    <h1 class="text-xl font-medium">SteadFast Courier Dashboard</h1>
                    <p class="my-4 font-medium text-lg">Check Balance</p>
                    <div class="inline-flex flex-col gap-4 sm:flex-row sm:items-center">
                        <button onclick="getBalance()"
                            class="bg-green-700 hover:bg-green-800 rounded-lg px-4 py-1 font-medium text-white max-w-[100px]">Balance</button>
                        <template x-if="$store.state.settings.apiKey && $store.state.settings.secretKey">
                            <div>
                                <template x-if="$store.state.balance !== ''">
                                    <p>your current balance is <strong x-text="$store.state.balance"></strong>.</p>
                                </template>
                                <template x-if="$store.state.balance === ''">
                                    <p>Check your current balance.</p>
                                </template>
                            </div>

                        </template>
                        <template x-if="!$store.state.settings.apiKey || !$store.state.settings.secretKey">
                            <p>Please provide api keys in the settings tab to check balance.</p>
                        </template>
                    </div>
                    <!--<div class="mt-4">-->
                    <!--    <p class="font-medium">Facing an issue, Please let me know.</p>-->
                    <!--    <div class="mt-4">-->
                    <!--        <a href="#" class="hover:underline">Facebook</a>-->
                    <!--        <a href="#" class="hover:underline ml-4 mt">Whatsapp</a>-->
                    <!--    </div>-->
                    <!--</div>-->
                </div>
            </template>
            {{-- SETTINGS --}}
            <template x-if="$store.state.activeTab=='settings'">
                <div class="flex flex-col gap-y-6">
                    <div class="flex justify-between items-center">
                        <div class="flex flex-row items-center gap-x-2">
                            <input type="checkbox" x-model="$store.state.settings.appStatus" id="appStatus" class="cursor-pointer"/>
                            <label for="appStatus" class="font-medium cursor-pointer">Enable/Disable App</label>
                        </div>
                        <button onclick="saveSettings()" type="button"
                            class="bg-green-700 hover:bg-green-800 rounded-lg px-4 py-1 font-medium text-white">Save
                            Settings</button>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="w-full sm:w-1/2">
                            <label for="apiKey" class="font-medium mb-2 inline-block">Api Key:</label>
                            <input type="text" x-model="$store.state.settings.apiKey" id="apiKey"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label for="secretKey" class="font-medium mb-2 inline-block">Secret Key:</label>
                            <input type="text" x-model="$store.state.settings.secretKey" id="secretKey"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                    </div>
                    <p class="font-medium">Please use these fields for printing the invoice.</p>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="w-full sm:w-1/2">
                            <label for="businessName" class="font-medium mb-2 inline-block">Business Name:</label>
                            <input type="text" x-model="$store.state.settings.businessName" id="businessName"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label for="businessAddress" class="font-medium mb-2 inline-block">Business Address:</label>
                            <input type="text" x-model="$store.state.settings.businessAddress" id="businessAddress"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="w-full sm:w-1/2">
                            <label for="businessEmail" class="font-medium mb-2 inline-block">Business Email:</label>
                            <input type="email" x-model="$store.state.settings.businessEmail" id="businessEmail"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                        <div class="w-full sm:w-1/2">
                            <label for="businessNumber" class="font-medium mb-2 inline-block">Business Number:</label>
                            <input type="text" x-model="$store.state.settings.businessNumber" id="businessNumber"
                                class="w-full rounded-lg px-2 py-1" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <label for="businessTerms" class="font-medium mb-2 block">Business Terms:</label>
                        <textarea id="businessTerms" rows="5" x-model="$store.state.settings.businessTerms"
                            class="w-full rounded-lg px-2 py-1 border"></textarea>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-1/2">
                            <label for="businessLogo" class="font-medium inline-block">Business Logo:</label>
                            <input type="file" x-ref="file" @change="handleFileUpload($refs.file)" id="businessLogo" />
                        </div>
                        <div class="w-full sm:w-1/2">
                                <template x-if="$store.state.settings.businessLogo && typeof($store.state.settings.businessLogo)=='string'">
                                    <img :src="'storage/businessLogo/'+ $store.state.settings.businessLogo" alt="businessLogo" class="max-h-8">
                                </template>
                                <template x-if="$store.state.settings.businessLogo==''">
                                    <img src="{{ asset('images/steadFast.png') }}" alt="businessLogo" class="max-h-8">
                                </template>
                        </div>
                    </div>
                </div>
            </template>

            {{-- ORDERS --}}
            <template x-if="$store.state.activeTab=='orders'">
                <div>
                    <template">
                        <div>
                            <div  style="display: block;width: 100%;overflow: auto;">
                                <button
                                class="bg-green-700 hover:bg-green-800 px-4 py-1 rounded-md text-white"
                                x-bind:class="$store.state.bulkSelect && '!bg-red-700 hover:!bg-red-800'"
                                @click="bulkSelect()"
                                x-text="$store.state.bulkSelect ? 'Cancel' : 'Bulk Selection'"></button>
                                <template x-if="$store.state.bulkOrders.length">
                                    <button
                                    class="bg-green-700 hover:bg-green-800 ml-3 px-4 py-1 rounded-md text-white"
                                    @click="bulkSend()">Send Bulk</button>
                                </template>


                                    <!-- Search Input -->
                                <input type="text" 
                                    placeholder="Search orders..." 
                                    class="border rounded-md" 
                                    x-model="$store.state.searchTerm" 
                                    @input="$store.state.searchOrders()" style="float: right;padding: 5px 15px;"/>

                            </div>

                
                            <div class="overflow-auto">
                                <table class="w-full text-left mt-4">
                                    <thead>
                                        <tr class="[&>th]:p-2 [&>th]:border [&>th]:whitespace-nowrap [&>th]:font-semibold">
                                            <template x-if="$store.state.bulkSelect">
                                            <th>Select</th>
                                            </template>
                                            <th>Order</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Consignment Id</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Send to SteadFast</th>
                                            <th>Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-for="(order, index) in $store.state.orders" :key="order.id">
                                            <tr class="[&>td]:p-2 [&>td]:border [&>td]:whitespace-nowrap">
                                                <template x-if="$store.state.bulkSelect">
                                                    <td>
                                                        <input type="checkbox" @click="addToBulk(order)">
                                                    </td>
                                                </template>
                                                <td>
                                                    <a :href="'https://admin.shopify.com/store/{{ strstr(auth()->user()->name, '.', true) }}/orders/' +
                                                    order.orderId"
                                                        class="hover:underline" target="_blank">
                                                        <span x-text="'#'+order.orderNumber"></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <span x-text="order.name"></span>
                                                </td>
                                                <td>
                                                    <span x-text="order.created_at"></span>
                                                </td>
                                                <td>
                                                    <span x-text="order.total"></span>
                                                </td>
                                                <td>
                                                    <span x-text="order.steadFastId ? order.steadFastId : 'Not set'"></span>
                                                </td>
                                                <td>
                                                    <span x-text="order.steadFastStatus ? order.steadFastStatus : 'Not set'"
                                                        class="border rounded-md px-4 py-1 text-center m-0"></span>
                                                    <button
                                                        class="bg-green-700 hover:bg-green-800 px-4 py-1 rounded-md text-white"
                                                        @click="checkStatus(order, index)">Check</button>
                                                </td>
                                                <td>
                                                    <input type="number" x-model="order.steadFastAmount"
                                                        class="px-4 py-1 w-24 rounded-md border focus:ring-0 focus:ring-offset-0 border-[#e5e7eb] focus:border-[#e5e7eb]"
                                                        min="1" :readonly="order.steadFastSend !== 0" />
                                                </td>
                                                <td class="text-center">
                                                    <button class="px-4 py-1 rounded-md bg-gray-300 text-black"
                                                        :class="!order.steadFastSend &&
                                                            '!bg-green-700 hover:!bg-green-800 !text-white'"
                                                        @click="sendToSteadFast(order, index)"
                                                        x-text="!order.steadFastSend ? 'Send' : 'Sent'"
                                                        :disabled="order.steadFastSend == 1"
                                                        :title="order.steadFastSend == 1 ? 'Already Sent.' : 'Click to send.'">
                                                    </button>
                                                </td>
                                                <td>
                                                    <a :href="order.steadFastId && '{{ route('printOrder', auth()->user()->id) }}'+'/?orderId='+order.orderId" target="_blank" class="bg-gray-300 text-black px-4 py-1 rounded-md"
                                                    :class="order.steadFastId && '!bg-green-700 hover:!bg-green-800 text-white'"
                                                    :title="order.steadFastId ? 'Click to print.' : 'Send to SteadFat first to print.'"
                                                    >Print</a>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </template>
                    <template x-if="!$store.state.orders.length">
                        <p>You don't have any order's yet.</p>
                    </template>
                </div>
            </template>
        </div>
        {{-- PAGINATION --}}
        <div class="mt-4">
            <template x-if="$store.state.activeTab=='orders' && $store.state.orders.length">
                <div x-html="$store.state.links">
                </div>
            </template>
        </div>
        {{-- ERROR MESSAGES --}}
        <template x-if="$store.state.msg">
            <p x-text="$store.state.msg.msg"
                class="bg-green-700 text-white py-1 px-2 absolute bottom-6 left-1/2 -translate-x-1/2 z-50 rounded-lg shadow-lg"
                :class="$store.state.msg.status == 'error' && '!bg-red-700'"></p>
        </template>
    </div>
    {{-- <div x-data>
        <button @click="console.log(Alpine.raw(Alpine.store('state').orders))">asdf</button>
    </div> --}}
@endsection
@section('scripts')
    @parent
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('state', {
                activeTab: 'dashboard',
                balance: '',
                settings: {
                    appStatus: {{ auth()->user()->appStatus === 1 ? 'true' : 'false' }},
                    apiKey: "{{ auth()->user()->apiKey }}",
                    secretKey: "{{ auth()->user()->secretKey }}",
                    businessName: "{{ auth()->user()->businessName }}",
                    businessAddress: "{{ auth()->user()->businessAddress }}",
                    businessEmail: "{{ auth()->user()->businessEmail }}",
                    businessNumber: "{{ auth()->user()->businessNumber }}",
                    businessLogo: "{{ auth()->user()->businessLogo }}",
                    businessTerms: "{{ str_replace('<br/>', '\n', auth()->user()->businessTerms) }}",
                },
                orders: {!! json_encode($orders->items()) !!},
                searchTerm: '', 
                setOrders(orders) {
                    this.orders = orders;
                },
                links: `{{ $orders->links() }}`,
                setLinks(links) {
                    this.links = links;
                },
                msg: false,
                bulkSelect: false,
                bulkOrders:[],
                searchOrders: async function() {
                    const searchTerm = this.searchTerm;
                    try {
                        const result = await axios({
                            url: "{{ route('home') }}", 
                            method: 'GET',
                            params: {
                                search: searchTerm,
                            }
                        });
                        
                        if (result.data.success) {
                            this.setOrders(result.data.orders);
                            this.setLinks(result.data.links);
                        }
                    } catch (error) {
                        console.error("Search error: ", error);
                    }
                }
            });
            getBalance(false);
        });

        async function showMsg(status, msg) {
            Alpine.store('state').msg = {
                status,
                msg
            };
            setTimeout(() => {
                Alpine.store('state').msg = false;
            }, 3000);
        }

        async function getBalance(show = true) {

            const apiKey = Alpine.store('state').settings.apiKey;
            const secretKey = Alpine.store('state').settings.secretKey;

            if (show && (!apiKey || !secretKey)) {
                return showMsg('error', 'Please provevide api credentials.');
            }

            if (show && !Alpine.store('state').settings.appStatus) {
                return showMsg('error', 'App is disabled. Enable the app to continue.');
            }

            try {
                if(show){
                    showMsg('success', 'Checking...');
                }
                const balance = await axios({
                    url: 'https://portal.packzy.com/api/v1/get_balance',
                    headers: {
                        'Api-Key': apiKey,
                        'Secret-Key': secretKey
                    }
                });
                if (balance.data.status == 200) {
                    Alpine.store('state').balance = balance.data.current_balance;
                    if (show) {
                        showMsg('success', 'Balance status updated.');
                    }
                } else {
                    if (show) {
                        showMsg('error', balance.data.message || 'Something went wrong');
                    }
                }
            } catch (error) {
                showMsg('error', (error.response.data || 'Something went wrong'));
            }

        };

        async function saveSettings() {

            let formData= new FormData();
            formData.append("appStatus", Alpine.store('state').settings.appStatus);
            formData.append("apiKey", Alpine.store('state').settings.apiKey);
            formData.append("secretKey", Alpine.store('state').settings.secretKey);
            formData.append("businessName", Alpine.store('state').settings.businessName);
            formData.append("businessAddress", Alpine.store('state').settings.businessAddress);
            formData.append("businessEmail", Alpine.store('state').settings.businessEmail);
            formData.append("businessNumber", Alpine.store('state').settings.businessNumber);
            formData.append("businessLogo", Alpine.store('state').settings.businessLogo);
            formData.append("businessTerms", Alpine.store('state').settings.businessTerms.replaceAll('\n','<br/>'));

            try {
                showMsg('success', 'Saving...');
                const setting = await axios({
                    url: "{{ route('saveSettings') }}",
                    headers:{
                        'Content-Type':'multipart/form-data'
                    },
                    method: 'post',
                    data: formData
                });

                if (setting.data.status == 'success') {
                    const userData= setting.data.userData;
                    Alpine.store('state').settings.appStatus= (userData.appStatus == 1)
                    Alpine.store('state').settings.apiKey= (userData.apiKey || '')
                    Alpine.store('state').settings.secretKey= (userData.secretKey || '')
                    Alpine.store('state').settings.businessName= (userData.businessName || '')
                    Alpine.store('state').settings.businessAddress= (userData.businessAddress || '')
                    Alpine.store('state').settings.businessEmail= ( userData.businessEmail || '')
                    Alpine.store('state').settings.businessNumber= ( userData.businessNumber || '')
                    Alpine.store('state').settings.businessLogo= ( userData.businessLogo || '')
                    Alpine.store('state').settings.businessTerms= ( userData.businessTerms ? userData.businessTerms.replaceAll('<br/>', '\n') : '')
                    showMsg('success', 'Setting successfully saved.');
                } else {
                    showMsg('error', 'Something went wrong.');
                }
            } catch (error) {
                showMsg('error', error.response.data.message || 'Something went wrong');
            }
        };

        async function sendToSteadFast(order, index) {

            const amount = Number(order.steadFastAmount) ? Number(order.steadFastAmount) : 200;
            const apiKey = Alpine.store('state').settings.apiKey;
            const secretKey = Alpine.store('state').settings.secretKey;

            const orderData = {
                invoice: order.orderId,
                recipient_name: order.name,
                recipient_phone: order.phone,
                recipient_address: order.address,
                cod_amount: amount,
                note:null
            };

            if (!apiKey || !secretKey) {
                return showMsg('error', 'Please provevide api credentials.');
            }
            if (!Alpine.store('state').settings.appStatus) {
                return showMsg('error', 'App is disabled. Enable the app to continue.');
            }
            if (order.steadFastSend) {
                return showMsg('error', `Order# ${order.orderNumber} alread sent`);
            };
            try {
                showMsg('success', 'Sending...');
                const steadFastData = await axios({
                    url: 'https://portal.packzy.com/api/v1/create_order',
                    method: 'post',
                    headers: {
                        'Api-Key': apiKey,
                        'Secret-Key': secretKey
                    },
                    data: orderData
                });
                if (steadFastData.data.status == 200) {
                    try {
                        const updateOrder = await axios({
                            url: "{{ route('updateOrder', '') }}" + '/' + order.id,
                            method: 'post',
                            data: steadFastData.data.consignment
                        });
                        if (updateOrder.data == 1) {
                            const consignment = steadFastData.data.consignment;
                            Alpine.store('state').orders[index].steadFastAmount = consignment.cod_amount;
                            Alpine.store('state').orders[index].steadFastSend = true;
                            Alpine.store('state').orders[index].steadFastId = consignment.consignment_id;
                            Alpine.store('state').orders[index].steadFastStatus = consignment.status;
                            showMsg('success', 'Successfully send to SteadFast.');
                        } else {
                            showMsg('error', 'Something went wrong');
                        }
                    } catch (error) {
                        showMsg('error', error.response.data.message || 'Something went wrong');
                    }
                } else {
                    showMsg('error', steadFastData.data.errors[Object.keys(steadFastData.data.errors)[0]] ||
                        'Something went wrong');
                }
            } catch (error) {
                showMsg('error', error.response.data || 'Something went wrong');
            }
        };

        async function bulkSend() {

            const apiKey = Alpine.store('state').settings.apiKey;
            const secretKey = Alpine.store('state').settings.secretKey;

            if (!apiKey || !secretKey) {
                return showMsg('error', 'Please provevide api credentials.');
            }
            if (!Alpine.store('state').settings.appStatus) {
                return showMsg('error', 'App is disabled. Enable the app to continue.');
            }

            const bulkOrders = Alpine.raw(Alpine.store('state').bulkOrders);
            const sentOrderIndex = bulkOrders.findIndex(order=>order.steadFastSend == 1);

            if(sentOrderIndex !== -1){
                return showMsg('error', `Order# ${bulkOrders[sentOrderIndex].orderNumber} alread sent`);
            }
            orderData = bulkOrders.map(order=>{
                return {
                    invoice: order.orderId,
                    recipient_name: order.name,
                    recipient_phone: order.phone,
                    recipient_address: order.address,
                    cod_amount: Number(order.steadFastAmount) ? Number(order.steadFastAmount) : 200,
                    note:null
                }
            });

            try {
                showMsg('success', 'Sending...');
                const steadFastData = await axios({
                    url: 'https://portal.packzy.com/api/v1/create_order/bulk-order',
                    method: 'post',
                    headers: {
                        'Api-Key': apiKey,
                        'Secret-Key': secretKey
                    },
                    data: orderData
                });

                if (steadFastData.data.status == 200) {
                    try {
                        const updateOrder = await axios({
                            url: "{{ route('bulkUpdateOrder') }}",
                            method: 'post',
                            data: steadFastData.data.data
                        });

                        if (updateOrder.data.every(element => element === 1)) {

                            const bulkData = steadFastData.data.data;

                            bulkData.forEach(item => {
                                let matchIndex = Alpine.store('state').orders.findIndex(order => order.orderId === item.invoice);
                                
                                if (matchIndex !== -1) {
                                     Alpine.store('state').orders[matchIndex].steadFastAmount = item.cod_amount;
                                     Alpine.store('state').orders[matchIndex].steadFastSend = true;
                                     Alpine.store('state').orders[matchIndex].steadFastId = item.consignment_id;
                                     Alpine.store('state').orders[matchIndex].steadFastStatus = item.status;
                                }
                            });
                            Alpine.store('state').bulkSelect=false;
                            Alpine.store('state').bulkOrders=[];
                            showMsg('success', 'Successfully send to SteadFast.');
                        } else {
                            showMsg('error', 'Something went wrong');
                        }
                    } catch (error) {
                        showMsg('error', error.response.data.message || 'Something went wrong');
                    }
                } else {
                    showMsg('error', steadFastData.data.errors[Object.keys(steadFastData.data.errors)[0]] ||
                        'Something went wrong');
                }
            } catch (error) {
                showMsg('error', error.response.data || 'Something went wrong');
            }
        };

        async function checkStatus(order, index) {

            const apiKey = Alpine.store('state').settings.apiKey;
            const secretKey = Alpine.store('state').settings.secretKey;

            if (!apiKey || !secretKey) {
                return showMsg('error', 'Please provevide api credentials.');
            }
            if (!Alpine.store('state').settings.appStatus) {
                return showMsg('error', 'App is disabled. Enable the app to continue.');
            }
            if (!order.steadFastSend) {
                return showMsg('error', 'First Send order to SteadFast to check status.');
            };

            try {
                showMsg('success', 'Checking...');
                const steadFastData = await axios({
                    url: 'https://portal.packzy.com/api/v1/status_by_cid/' + order.steadFastId,
                    headers: {
                        'Api-Key': apiKey,
                        'Secret-Key': secretKey
                    },
                });
                if (steadFastData.data.status === 200) {
                    try {
                        const updateOrder = await axios({
                            url: "{{ route('updateOrder', '') }}" + '/' + order.id,
                            method: 'post',
                            data: {
                                updateStatus: steadFastData.data.delivery_status
                            }
                        });
                        if (updateOrder.data == 1) {
                            Alpine.store('state').orders[index].steadFastStatus = steadFastData.data.delivery_status;
                            showMsg('success', 'Status successfully updated');
                        } else {
                            showMsg('error', 'Something went wrong');
                        }
                    } catch (error) {
                        showMsg('error', error.response.data.message || 'Something went wrong');
                    }
                } else {
                    showMsg('error', steadFastData.data.message || 'Something went wrong');
                }
            } catch (error) {
                showMsg('error', error.response.data || 'Something went wrong');
            }
        }

        function handleFileUpload(input){
            const originalLogo = "{{auth()->user()->businessLogo}}";
            const file =  input.files[0];
            if(!file){
             return   Alpine.store('state').settings.businessLogo = originalLogo;
            }
            return Alpine.store('state').settings.businessLogo = file;
        }

        document.addEventListener("click", function(e) {
            const pagination = document.querySelector('nav[role="navigation"]');
            if(pagination){
                e.preventDefault();
                let url = e.target.href;
                if(e.target.nodeName=='path'){
                    url = e.target.parentElement.parentElement.href;
                }
                if(e.target.nodeName=='svg'){
                    url = e.target.parentElement.href;
                }
                if(url){
                    reloadData(url)
                }
            }
        });

        async function reloadData(url) {
                let result = await axios({
                    url: url,
                    method: 'get',
                });
                if (result.data.success) {
                    Alpine.store('state').setOrders(result.data.orders ?? "")
                    Alpine.store('state').setLinks(result.data.links ?? "")
                }
        }
        
        function bulkSelect(){
            Alpine.store('state').bulkSelect = !Alpine.store('state').bulkSelect;
            if(!Alpine.store('state').bulkSelect){
                Alpine.store('state').bulkOrders = [];
            }
        }

        function addToBulk(order){

            if(!Alpine.store('state').bulkOrders.find(item=>item.id == order.id)){
                Alpine.store('state').bulkOrders.push(order);
            }else{
                Alpine.store('state').bulkOrders = Alpine.store('state').bulkOrders.filter(item=>item.id !== order.id);
            }
        }

    </script>
@endsection
