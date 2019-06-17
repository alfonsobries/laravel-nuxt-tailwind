<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Provider::paginate($request->input('per_page', 20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProviderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request)
    {
        $provider = Provider::create($request->validated());

        return $provider;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function show(Provider $provider)
    {
        $this->authorize('show', $provider);

        return $provider;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ProviderRequest  $request
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, Provider $provider)
    {
        $provider->update($request->validated());

        return $provider;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        $this->authorize('destroy', $provider);

        return tap($provider)->delete();
    }
}
