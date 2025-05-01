<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Throwable;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return ApiResponse::success($this->userService->all(), 'User retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = $this->userService->create($validated);

            return ApiResponse::success($user, 'User created successfully');
        } catch (ValidationException $e) {

            return ApiResponse::error($e->errors(), 'Validation failed', 422);
        } catch (Exception $e) {

            return ApiResponse::error([], $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $user = $this->userService->find($id); //findOrFail

            if (!$user) {
                return ApiResponse::error([], 'User not found', 404);
            }

            return ApiResponse::success($user, 'User retrieved successfully');
        } catch (Exception $e) {

            return ApiResponse::error([], $e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->userService->find($id);

            if (!$user) {
                return ApiResponse::error([], 'User not found', 404);
            }

            $this->userService->delete($user);

            return ApiResponse::success([], 'User deleted successfully');
        } catch (Exception $e) {

            return ApiResponse::error([], $e->getMessage(), 500);
        }
    }
}
