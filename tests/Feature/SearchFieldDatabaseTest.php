<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SearchField;

class SearchFieldDataBaseTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDatabase()
    {
    	$searchField = factory(SearchField::class)->create();

        $this->assertDatabaseHas('search_fields', ['sequence'=>$searchField['sequence']]);
    }
}
