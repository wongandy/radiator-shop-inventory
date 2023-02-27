<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\ProductTransfersEdit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProductTransfersEditTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(ProductTransfersEdit::class);

        $component->assertStatus(200);
    }
}
