<?php

namespace App\Http\Controllers;

use App\Http\Requests\LayoutRequest;
use App\Models\Layout;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Layout::paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\LayoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LayoutRequest $request)
    {
        $layout = Layout::create($request->validated());

        return $layout;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function show(Layout $layout)
    {
        $this->authorize('show', $layout);

        return $layout;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\LayoutRequest  $request
     * @param  \App\Models\Layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function update(LayoutRequest $request, Layout $layout)
    {
        $layout->update($request->validated());

        return $layout;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Layout $layout)
    {
        $this->authorize('destroy', $layout);

        return tap($layout)->delete();
    }
}
