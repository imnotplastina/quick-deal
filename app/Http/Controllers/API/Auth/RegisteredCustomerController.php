<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Customer\CustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RegisteredCustomerController extends Controller
{
    public function __invoke(CustomerRequest $request): JsonResponse
    {
        $data = $request->validated();

        $customer = Customer::firstOrCreate([
            'email' => $data['email']], $data
        );

        Auth::login($customer);

        return new JsonResponse(
            data: new CustomerResource($customer),
            status: Response::HTTP_CREATED
        );
    }
}
