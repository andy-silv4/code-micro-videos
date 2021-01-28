<?php

namespace Tests\Stubs\Controllers;

use App\Http\Controllers\Api\BasicCRUDController;
use Tests\Stubs\Models\CategoryStub;

class CategoryControllerStub extends BasicCRUDController
{
    protected function model()
    {
        return CategoryStub::class;
    }

    protected function rulesStore()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'nullable'
        ];
    }

    protected function rulesUpdate()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'nullable'
        ];
    }
}