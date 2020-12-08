<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class, 1)->create();

        $categories = Genre::all();

        $this->assertCount(1, $categories);

        $genreKey = array_keys($categories->first()->getAttributes());

        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ], 
            $genreKey
        );
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'Genre'
        ]);

        $genre->refresh();

        $this->assertEquals(36, strlen($genre->id));
    }

    public function testCreateWithName()
    {
        $genre = Genre::create([
            'name' => 'Genre'
        ]);

        $genre->refresh();

        $this->assertEquals('Genre', $genre->name);
        $this->assertTrue($genre->is_active);
    }

    public function testCreateWithIsActiveFalse()
    {
        $genre = Genre::create([
            'name' => 'Genre',
            'is_active' => false
        ]);

        $this->assertFalse($genre->is_active);
    }

    public function testCreateWithIsActiveTrue()
    {
        $genre = Genre::create([
            'name' => 'Genre',
            'is_active' => true
        ]);

        $this->assertTrue($genre->is_active);
    }

    public function testUpdate()
    {
        $genre = factory(Genre::class)->create();

        $data = [
            'name' => 'Genre Updated',
            'is_active' => false,
        ];

        $genre->update($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $genre->{$key});
        }
    }

    public function testDelete()
    {
        $genre = factory(Genre::class)->create();

        $genre->delete();

        $this->assertNull(Genre::find($genre->id));
    }

    public function testSoftDelete()
    {
        $genre = factory(Genre::class)->create()->first();

        $genre->delete();

        $this->assertNotNull($genre->deleted_at);
    }

    public function testRestoreDelete()
    {
        $genre = factory(Genre::class)->create()->first();

        $genre->delete();

        $genre->restore();

        $this->assertNotNull(Genre::find($genre->id));
    }
}
