<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Customer\PaymentRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use App\Supports\AmountValue;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function payment(PaymentRequest $request): CustomerResource
    {
        $customer = $request->user();

        $customer->update([
            'balance' => new AmountValue(
                $customer->balance->value() + $request->validated('amount')
            )]);

        return new CustomerResource($customer);
    }
}
