<?php

namespace Acacia\AcaciaRelationships\Http\Controllers;

use Acacia\AcaciaRelationships\Models\Relationship;
use Acacia\AcaciaRelationships\Repositories\Relationships;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\IndexRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\ViewRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\StoreRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\UpdateRequest;
use Acacia\AcaciaRelationships\Http\Requests\Relationship\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class AcaciaRelationshipController extends Controller
{
    public function __construct(private Relationships $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        $model = Relationship::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("AcaciaRelationships/Js/Pages/Index", compact("can"));
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $model = Relationship::class;
        $can = [
            "viewAny" =>
                \Auth::check() && \Auth::user()->can("viewAny", $model),
            "create" => \Auth::check() && \Auth::user()->can("create", $model),
        ];
        return Inertia::render("AcaciaRelationships/Js/Pages/Create", compact("can"));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            $payload = $this->repo->store($request->sanitizedObject());
            $success = "Record created successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Show the specified resource.
     * @param ViewRequest $request
     * @param Relationship $relationship
     * @return Response
     */
    public function show(
        ViewRequest $request,
        Relationship $relationship
    ): Response {
        $model = $this->repo->setModel($relationship)->show();
        return Inertia::render("AcaciaRelationships/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param Relationship $relationship
     * @return Response
     */
    public function edit(Request $request, Relationship $relationship): Response
    {
        $model = $this->repo->setModel($relationship)->show();
        return Inertia::render("AcaciaRelationships/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Relationship $relationship
     * @return RedirectResponse
     */
    public function update(
        UpdateRequest $request,
        Relationship $relationship
    ): RedirectResponse {
        try {
            $payload = $this->repo
                ->setModel($relationship)
                ->update($request->sanitizedObject());
            $success = "Record updated successfully";
            return back()->with(compact("success", "payload"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param DestroyRequest $request
     * @param Relationship $relationship
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        Relationship $relationship
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($relationship)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}
