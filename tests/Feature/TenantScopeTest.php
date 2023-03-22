<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
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

        $filename = $now->year . '_' . $now->format('m') . '_' . $now->format('d') . '_' . $now->format('h')
            . $now->format('i') . $now->format('s')
            . '_create_tests_table.php';

        $this->assertTrue(File::exists(database_path('migrations/' . $filename)));
        $this->assertStringContainsString('$table->unsignedBigInteger(\'tenant_id\')->index();', File::get(database_path('migrations/' . $filename)));

        File::delete(database_path('migrations/' . $filename));
        File::delete(app_path('models/Test.php'));
    }

    /** @test */
    public function a_user_can_only_see_users_in_the_same_tenant()
    {
        $tenant1 = Tenant::factory()->create();
        $tenant2 = Tenant::factory()->create();

        $user1 = User::factory()->create([
            'tenant_id' => $tenant1,
        ]);

        User::factory()->count(9)->create([
            'tenant_id' => $tenant1,
        ]);

        User::factory()->count(10)->create([
            'tenant_id' => $tenant2,
        ]);

        // $this->actingAs($user1);
        auth()->login($user1);

        $this->assertEquals(10, User::count());
    }
}
