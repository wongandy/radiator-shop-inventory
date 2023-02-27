<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ProductOutsCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductOutsCreateTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ProductOutsCreate::class);

        $component->assertStatus(200);
    }
}
