<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColumnRequest;
use App\Models\Column;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Column::paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ColumnRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColumnRequest $request)
    {
        $column = Column::create($request->validated());

        return $column;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function show(Column $column)
    {
        $this->authorize('show', $column);

        return $column;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ColumnRequest  $request
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function update(ColumnRequest $request, Column $column)
    {
        $column->update($request->validated());

        return $column;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Column  $column
     * @return \Illuminate\Http\Response
     */
    public function destroy(Column $column)
    {
        $this->authorize('destroy', $column);

        return tap($column)->delete();
    }
}
