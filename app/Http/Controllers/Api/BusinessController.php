<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->role !== 'owner') {
            return response()->json(
                [
                    'response' => Response::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'message' => 'Unauthorized',
                    'data' => null,
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'owner_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'response' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'success' => false,
                    'message' => 'Validation error',
                    'data' => null,
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $business = Business::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'owner_id' => $user->id,
        ]);

        return response()->json(
            [
                'response' => Response::HTTP_CREATED,
                'success' => true,
                'message' => 'Business created',
                'data' => $business,
            ],
            Response::HTTP_CREATED
        );
    }
}
