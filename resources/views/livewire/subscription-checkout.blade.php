<div class="space-y-8">
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">1. Billing Information (For Invoice)</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" wire:model="billing_name" placeholder="Name for Invoice" 
                       class="mt-1 w-full p-2 border border-gray-300 rounded-md @error('billing_name') border-red-500 @enderror">
                @error('billing_name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Billing Email</label>
                <input type="email" wire:model="billing_email" placeholder="Billing Email" 
                       class="mt-1 w-full p-2 border border-gray-300 rounded-md @error('billing_email') border-red-500 @enderror">
                @error('billing_email') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Billing Address (Full Address)</label>
            <textarea wire:model="billing_address" placeholder="Full address required for invoicing" rows="3" 
                      class="mt-1 w-full p-2 border border-gray-300 rounded-md @error('billing_address') border-red-500 @enderror"></textarea>
            @error('billing_address') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>
        
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">2. Select Payment Method ({{ $plan->name }} - ${{ number_format($plan->price, 2) }})</h3>
        
        <div class="flex flex-col md:flex-row gap-4">
            
            <button wire:click="$set('payment_method_id', 'card')" type="button" 
                    class="flex-1 p-4 rounded-lg border-2 font-medium transition duration-150 {{ $payment_method_id === 'card' ? 'border-indigo-600 bg-indigo-50 shadow-md' : 'border-gray-300 hover:border-indigo-400' }}">
                Credit Card (Immediate Activation)
            </button>

            <button wire:click="$set('payment_method_id', 'paypal')" type="button" 
                    class="flex-1 p-4 rounded-lg border-2 font-medium transition duration-150 {{ $payment_method_id === 'paypal' ? 'border-indigo-600 bg-indigo-50 shadow-md' : 'border-gray-300 hover:border-indigo-400' }}">
                PayPal (Immediate Activation)
            </button>

            <button wire:click="$set('payment_method_id', 'invoice')" type="button" 
                    class="flex-1 p-4 rounded-lg border-2 font-medium transition duration-150 {{ $payment_method_id === 'invoice' ? 'border-indigo-600 bg-indigo-50 shadow-md' : 'border-gray-300 hover:border-indigo-400' }}">
                Invoice / Bank Transfer (Manual Activation)
            </button>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow border-2 {{ $payment_method_id === 'invoice' ? 'border-yellow-400' : 'border-green-400' }}">
        
        @if($payment_method_id === 'invoice')
            <h3 class="text-lg font-bold text-yellow-700 mb-3">Manual Activation Notice:</h3>
            <p class="text-sm text-gray-700 mb-4">
                Upon submitting, your invoice will be issued. The project will be **manually activated** only after your payment has been received and verified.
            </p>
            <button wire:click="checkout" type="button" class="w-full py-3 bg-yellow-600 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-700 transition">
                Generate Invoice & Submit Details
            </button>

        @else
            <h3 class="text-lg font-bold text-green-700 mb-3">Secure Payment (Immediate Activation)</h3>

            {{-- Placeholder for actual payment forms --}}
            <div class="payment-gateway-placeholder border border-dashed border-gray-400 p-6 rounded-lg text-center">
                
                @if($payment_method_id === 'card')
                    <p class="mb-3 font-semibold">Credit Card Checkout (Stripe Elements Integration Pending)</p>
                    <div id="card-element" class="p-3 border rounded">
                        <p class="text-sm text-gray-500">Stripe card input field placeholder...</p>
                    </div>
                @elseif($payment_method_id === 'paypal')
                    <p class="mb-3 font-semibold">PayPal Button (SDK Integration Pending)</p>
                    <button class="w-full py-2 bg-blue-700 text-white rounded-md">Pay with PayPal</button>
                @endif
                
                <button wire:click="checkout" type="button" class="mt-4 w-full py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition">
                    Complete Secure Payment
                </button>
            </div>
        @endif
        
        <a href="{{ route('tenant.billing') }}" class="mt-4 block text-center text-indigo-600 hover:text-indigo-800 font-medium">&larr; Change Plan</a>
    </div>

</div>