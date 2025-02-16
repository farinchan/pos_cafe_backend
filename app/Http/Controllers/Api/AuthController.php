<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * @unauthenticated
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
            'business_id' => 'required',
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

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'business_id' => $request->business_id,
        ]);

        return response()->json(
            [
                'response' => Response::HTTP_CREATED,
                'success' => true,
                'message' => 'User created',
                'data' => $user,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * @unauthenticated
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'response' => response::HTTP_UNPROCESSABLE_ENTITY,
                    'success' => false,
                    'message' => 'Validation error',
                    'data' => null,
                    'errors' => $validator->errors(),
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(
                [
                    'response' => response::HTTP_UNAUTHORIZED,
                    'success' => false,
                    'message' => 'Unauthorized',
                    'data' => null,
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(
            [
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Login success',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                ],
            ],
            Response::HTTP_OK
        )->header('Authorization', 'Bearer ' . $token);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(
            [
                'response' => Response::HTTP_OK,
                'success' => true,
                'message' => 'Logout success',
                'data' => null,
            ],
            Response::HTTP_OK
        );
    }
}
