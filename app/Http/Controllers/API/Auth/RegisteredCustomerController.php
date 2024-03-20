<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Customer\CustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use App\Supports\AmountValue;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RegisteredCustomerController extends Controller
{
    public function __invoke(CustomerRequest $request): JsonResponse
    {
        $data = $request->validated();

        $customer = Customer::firstOrCreate([
            'email' => $data['email']], [
                'name' => $data['name'],
                'balance' => new AmountValue('0')
            ]);

        Auth::login($customer);

        return new JsonResponse(
            data: new CustomerResource($customer),
            status: Response::HTTP_CREATED
        );
    }
}
