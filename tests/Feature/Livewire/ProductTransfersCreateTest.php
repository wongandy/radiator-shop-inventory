<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ProductTransfersCreate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductTransfersCreateTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ProductTransfersCreate::class);

        $component->assertStatus(200);
    }
}
