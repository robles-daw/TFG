<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiaEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_create_form_uses_quill_editor(): void
    {
        $admin = User::factory()->create([
            'rol' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.noticias.create'));

        $response->assertOk();
        $response->assertSee('cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js', false);
        $response->assertSee('id="contenido-editor"', false);
        $response->assertSee('type="hidden" name="contenido"', false);
    }
}
