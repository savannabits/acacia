<?php

namespace Acacia\Core\Http\Controllers;

use Acacia\Core\Models\Schematic;
use Acacia\Core\Repos\GPanelRepo;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SchematicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('acacia::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('acacia::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $schematic = GPanelRepo::createBlueprint($request->collect(["table","existingTable","recreate"]));
            return back()->with(['success' =>'Schematic created successfully','payload' => $schematic]);
        } catch (\Throwable $exception) {
            \Log::error($exception);
            return back()->withErrors(['message' => $exception->getMessage()]);
        }
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
     * @param Schematic $schematic
     * @return Response
     */
    public function edit(Schematic $schematic)
    {
        return Inertia::render('Core/Js/Pages/GPanel/AcaciaSchematics/Manage',["model" => $schematic]);
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
