<?php

namespace Acacia\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Acacia\Core\Models\AcaciaMenu;

class AcaciaMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Core/Js/Pages/Backend/AcaciaMenu/Index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('acacia::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('acacia::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param AcaciaMenu $acaciaMenu
     * @return Response
     */
    public function edit(AcaciaMenu $acaciaMenu): Response
    {
        $acaciaMenu->load('parent');
        return Inertia::render("Core/Js/Pages/Backend/AcaciaMenu/Edit",["model" => $acaciaMenu]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
