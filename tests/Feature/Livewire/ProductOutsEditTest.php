<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ProductOutsEdit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductOutsEditTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ProductOutsEdit::class);

        $component->assertStatus(200);
    }
}
