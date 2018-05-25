<?php

namespace Tests\Unit;

use App\Serie;
use Tests\TestCase;

class SerieTest extends TestCase
{
   function test_create_serie_with_slug()
    {
        $serie = new Serie([
            'serie' => "The Handmaid's Tale"
        ]);
        $this->assertSame('the-handmaids-tale', $serie->slug);
    }
}