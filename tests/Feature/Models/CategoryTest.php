<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Category::class, 1)->create();

        $categories = Category::all();

        $this->assertCount(1, $categories);

        $categoryKey = array_keys($categories->first()->getAttributes());

        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ], 
            $categoryKey
        );
    }

    public function testCreate()
    {
        $category = Category::create([
            'name' => 'Category'
        ]);

        $category->refresh();

        $this->assertEquals(36, strlen($category->id));
    }

    public function testCreateWithName()
    {
        $category = Category::create([
            'name' => 'Category'
        ]);

        $category->refresh();

        $this->assertEquals('Category', $category->name);
        $this->assertNull($category->description);
        $this->assertTrue($category->is_active);
    }

    public function testCreateWithDescriptionNull()
    {
        $category = Category::create([
            'name' => 'Category',
            'description' => null
        ]);

        $this->assertNull($category->description);
    }

    public function testCreateWithDescription()
    {
        $category = Category::create([
            'name' => 'Category',
            'description' => 'Category Description'
        ]);

        $this->assertEquals('Category Description', $category->description);
    }

    public function testCreateWithIsActiveFalse()
    {
        $category = Category::create([
            'name' => 'Category',
            'is_active' => false
        ]);

        $this->assertFalse($category->is_active);
    }

    public function testCreateWithIsActiveTrue()
    {
        $category = Category::create([
            'name' => 'Category',
            'is_active' => true
        ]);

        $this->assertTrue($category->is_active);
    }

    public function testUpdate()
    {
        $category = factory(Category::class)->create();

        $data = [
            'name' => 'Category Updated',
            'description' => 'Description Category Updated',
            'is_active' => false,
        ];

        $category->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $category->{$key});
        }
    }

    public function testDelete()
    {
        $category = factory(Category::class)->create();

        $category->delete();

        $this->assertNull(Category::find($category->id));
    }

    public function testSoftDelete()
    {
        $category = factory(Category::class)->create()->first();

        $category->delete();

        $this->assertNotNull($category->deleted_at);
    }

    public function testRestoreDelete()
    {
        $category = factory(Category::class)->create()->first();

        $category->delete();

        $category->restore();

        $this->assertNotNull(Category::find($category->id));
    }
}
