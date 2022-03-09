<?php

namespace Acacia\Users\Http\Controllers;

use Acacia\Users\Models\User;
use Acacia\Users\Repositories\Users;
use Acacia\Users\Http\Requests\User\IndexRequest;
use Acacia\Users\Http\Requests\User\StoreRequest;
use Acacia\Users\Http\Requests\User\UpdateRequest;
use Acacia\Users\Http\Requests\User\DestroyRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function __construct(private Users $repo)
    {
    }
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return Response
     */
    public function index(IndexRequest $request): Response
    {
        return Inertia::render("Users/Js/Pages/Index");
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render("Users/Js/Pages/Create");
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
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function show(Request $request, User $user): Response
    {
        $model = $this->repo->setModel($user)->show();
        return Inertia::render("Users/Js/Pages/Show", compact("model"));
    }

    /**
     * Edit the specified resource.
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $model = $this->repo->setModel($user)->show();
        return Inertia::render("Users/Js/Pages/Edit", compact("model"));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        try {
            $payload = $this->repo
                ->setModel($user)
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
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(
        DestroyRequest $request,
        User $user
    ): RedirectResponse {
        try {
            $res = $this->repo->setModel($user)->destroy();
            $success = "Record deleted successfully";
            return back()->with(compact("success"));
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(["error" => $exception->getMessage()]);
        }
    }
}