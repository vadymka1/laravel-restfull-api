<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\JWTService\JWTService;
use App\Services\ModelServices\UserSaveService;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = DB::collection('users')->get();

        return response()->json(['data' => $users], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(['data' => $user], 200);
    }

    /**
     * @param UserRequest $request
     * @param JWTService $service
     * @param User $user
     * @param UserSaveService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request, JWTService $service, User $user, UserSaveService $userService)
    {
        $authUser = $service->getAuthUser($request->header('Authorization'));

        $data = $request->only([
            'first_name',
            'last_name',
            'email',
        ]);

        $data['user_id'] = $authUser->_id;

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $status = $user->_id ? 201 : 200;

        $userService->run($user, $data);

        return response()->json(['data' => $user], $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}
