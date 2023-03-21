<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class TenantScopeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_model_has_a_tenant_id_on_the_migration()
    {
        $now = now();

        $this->artisan('make:model Test -m');

        $filename = $now->year . '_' . $now->format('m') . '_' . $now->format('d') . '_' . $now->format('h') . $now->format('i') . $now->format('s') . '_create_tests_table.php';

        $this->assertTrue(File::exists(database_path('migrations/' . $filename)));

        File::delete(database_path('migrations/' . $filename));
        File::delete(app_path('Test.php'));
    }
}
