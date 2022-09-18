<?php

namespace Laravolt\Crud;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\View;

abstract class WebCrudController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return View::first([request()->route()->getName(), 'crud::index']);
    }

    public function show(mixed $id)
    {
        return View::first([request()->route()->getName(), 'crud::show']);
    }

    public function create()
    {
        return View::first([request()->route()->getName(), 'crud::create']);
    }

    public function edit(mixed $id)
    {
        return View::first([request()->route()->getName(), 'crud::edit']);
    }

    public function store(mixed $id)
    {

    }

    public function destroy(mixed $id)
    {

    }
}
