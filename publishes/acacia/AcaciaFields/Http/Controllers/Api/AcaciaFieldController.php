<?php

namespace Acacia\AcaciaFields\Http\Controllers\Api;

use Acacia\AcaciaFields\Models\Field;
use Acacia\AcaciaFields\Repositories\Fields;
use Acacia\AcaciaFields\Http\Requests\Field\IndexRequest;
use Acacia\AcaciaFields\Http\Requests\Field\DtRequest;
use Acacia\AcaciaFields\Http\Requests\Field\ViewRequest;
use Acacia\AcaciaFields\Http\Requests\Field\StoreRequest;
use Acacia\AcaciaFields\Http\Requests\Field\UpdateRequest;
use Acacia\AcaciaFields\Http\Requests\Field\DestroyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Savannabits\Acacia\Helpers\ApiResponse;

class AcaciaFieldController extends Controller
{
    public function __construct(private ApiResponse $api, private Fields $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        try {
            $data = $this->repo->index();
            return $this->api
                ->success()
                ->message("List of AcaciaFields")
                ->payload($data)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * @param DtRequest $request
     * @return LengthAwarePaginator|JsonResponse
     */
    public function dt(DtRequest $request): LengthAwarePaginator|JsonResponse
    {
        try {
            return $this->repo->dt();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Field $field
     * @return JsonResponse
     */
    public function show(ViewRequest $request, Field $field): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($field)->show();
            $success = "Single record fetched";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Field $field
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Field $field): JsonResponse
    {
        try {
            $payload = $this->repo
                ->setModel($field)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Field $field
     * @return JsonResponse
     */
    public function destroy(DestroyRequest $request, Field $field): JsonResponse
    {
        try {
            $payload = $this->repo->setModel($field)->destroy();
            $success = "Record deleted successfully";
            return $this->api
                ->success()
                ->message($success)
                ->payload($payload)
                ->send();
        } catch (\Throwable $e) {
            \Log::error($e);
            return $this->api
                ->failed()
                ->code(500)
                ->message($e->getMessage())
                ->send();
        }
    }
}
