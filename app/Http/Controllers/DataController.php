<?php

namespace App\Http\Controllers;

use App\Http\Requests\DataRequest;
use App\Models\Data;
use App\Models\Layout;
use Illuminate\Http\Request;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Layout $layout)
    {
        return $layout->data()->paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\DataRequest  $request
     * @param  \App\Models\Layout  $layout
     * @return \Illuminate\Http\Response
     */
    public function store(DataRequest $request, Layout $layout)
    {
        $data = $layout->data()->create($request->validated());

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Layout  $layout
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function show(Layout $layout, Data $data)
    {
        $this->authorize('show', $data);

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\DataRequest  $request
     * @param  \App\Models\Layout  $layout
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function update(DataRequest $request, Layout $layout, Data $data)
    {
        $data->update($request->validated());

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Layout  $layout
     * @param  \App\Models\Data  $data
     * @return \Illuminate\Http\Response
     */
    public function destroy(Layout $layout, Data $data)
    {
        $this->authorize('destroy', $data);

        return tap($data)->delete();
    }
}
