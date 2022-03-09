<?php

namespace Acacia\Core\Http\Controllers\Api;

use Acacia\Core\Models\Schematic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Savannabits\Acacia\Helpers\ApiResponse;

class SchematicController extends Controller
{
    public function __construct(private ApiResponse $api)
    {
    }

    public function index()
    {
        $q = Schematic::query();
        $data = \PrimevueDatatables::of($q)->make();
        return $this->api->success()->payload($data)->send();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function dt()
    {
        $q = Schematic::query();
        return \PrimevueDatatables::of($q)->make();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function fields(Request $request, Schematic $schematic) {
        return \PrimevueDatatables::of($schematic->fields()->getQuery())->make();
    }

    public function relationships(Request $request, Schematic $schematic) {
        return \PrimevueDatatables::of($schematic->relationships()->getQuery())->make();
    }


}
