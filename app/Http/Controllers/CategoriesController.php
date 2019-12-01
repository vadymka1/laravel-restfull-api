<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\User;
use App\Services\JWTService\JWTService;
use App\Services\ModelServices\CategoriesByUserService;
use App\Services\ModelServices\CategorySaveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Return category collection
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = DB::collection('categories')->get();

        return new JsonResponse(['data' => $categories]);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category)
    {
        return new JsonResponse(['data' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @param JWTService $service
     * @param CategorySaveService $categorySaveService
     * @return JsonResponse
     */
    public function store(CategoryRequest $request, Category $category, JWTService $service, CategorySaveService $categorySaveService) : JsonResponse
    {
        $user = $service->getAuthUser($request->header('Authorization'));

        $data = $request->only(['name']);

        $data['user_id'] = $user->_id;

        $categorySaveService->run($category, $data);

        return new JsonResponse([$category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return new JsonResponse(null, 204);
    }

    /**
     * @param User $user
     * @param CategoriesByUserService $categoriesByUserService
     * @return JsonResponse
     */
    public function showByUser(User $user, CategoriesByUserService $categoriesByUserService)
    {
        $categories = $categoriesByUserService->run($user);

        return new JsonResponse(['data' => $categories]);
    }
}
