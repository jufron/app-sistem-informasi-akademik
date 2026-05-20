<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardController;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles so Spatie Role works correctly in the test environment
        $this->seed(RoleSeeder::class);
    }

    /**
     * Test 1: Verify the controller class exists, has correct namespace, name, and inheritance.
     */
    public function test_controller_class_name_and_inheritance(): void
    {
        $controllerClass = DashboardController::class;

        // Check if class exists
        $this->assertTrue(class_exists($controllerClass), "DashboardController class does not exist.");

        // Check namespace and class name match
        $this->assertEquals('App\Http\Controllers\DashboardController', $controllerClass);

        // Check if class base name is exactly DashboardController
        $reflection = new ReflectionClass($controllerClass);
        $this->assertEquals('DashboardController', $reflection->getShortName(), "The controller class name is not correct.");

        // Check inheritance
        $this->assertTrue(
            is_subclass_of($controllerClass, 'App\Http\Controllers\Controller'),
            "DashboardController must extend App\Http\Controllers\Controller."
        );
    }

    /**
     * Test 2: Verify that the dashboard method exists and is public in the controller.
     */
    public function test_controller_has_dashboard_method(): void
    {
        $controllerClass = DashboardController::class;
        $reflection = new ReflectionClass($controllerClass);

        $this->assertTrue(
            $reflection->hasMethod('dashboard'),
            "Method 'dashboard' is missing in DashboardController."
        );

        $method = $reflection->getMethod('dashboard');
        $this->assertTrue(
            $method->isPublic(),
            "Method 'dashboard' in DashboardController must be public."
        );
    }

    /**
     * Test 3: Verify the route is mapped correctly and protected by auth middleware.
     */
    public function test_route_path_and_middleware(): void
    {
        // 1. Verify Route URL matches the name
        $this->assertEquals(url('/dashboard'), route('dashboard'), "Route 'dashboard' does not resolve to the correct URL.");

        // 2. Verify that the route uses the correct controller and action
        $route = app('router')->getRoutes()->getByName('dashboard');
        $this->assertNotNull($route, "Route 'dashboard' is not registered.");
        $this->assertEquals(
            DashboardController::class . '@dashboard',
            $route->getActionName(),
            "Route 'dashboard' is not mapped to the correct controller action."
        );

        // 3. Verify that the route has auth middleware applied
        $this->assertContains('auth', $route->middleware(), "Route 'dashboard' is missing the 'auth' middleware protection.");

        // 4. Verify unauthenticated/guest users are redirected to the login page
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test 4: Verify Dashboard view and data when logged in as an ADMIN.
     */
    public function test_dashboard_renders_admin_view_with_correct_data(): void
    {
        // Create user and assign 'admin' role
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($admin) {
            return $viewUser->id === $admin->id;
        });
    }

    /**
     * Test 5: Verify Dashboard view and data when logged in as a GURU.
     */
    public function test_dashboard_renders_guru_view_with_correct_data(): void
    {
        // Create user and assign 'guru' role
        $guru = User::factory()->create();
        $guru->assignRole('guru');

        $response = $this->actingAs($guru)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.guru.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($guru) {
            return $viewUser->id === $guru->id;
        });
    }

    /**
     * Test 6: Verify Dashboard view and data when logged in as KEPALA SEKOLAH.
     */
    public function test_dashboard_renders_kepala_sekolah_view_with_correct_data(): void
    {
        // Create user and assign 'kepala-sekolah' role
        $kepalaSekolah = User::factory()->create();
        $kepalaSekolah->assignRole('kepala-sekolah');

        $response = $this->actingAs($kepalaSekolah)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.kepala-sekolah.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($kepalaSekolah) {
            return $viewUser->id === $kepalaSekolah->id;
        });
    }

    /**
     * Test 7: Verify Dashboard view and data when logged in as a SISWA.
     */
    public function test_dashboard_renders_siswa_view_with_correct_data(): void
    {
        // Create user and assign 'siswa' role
        $siswa = User::factory()->create();
        $siswa->assignRole('siswa');

        $response = $this->actingAs($siswa)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.siswa.dashboard');
        $response->assertViewHas('user', function ($viewUser) use ($siswa) {
            return $viewUser->id === $siswa->id;
        });
    }

    /**
     * Test 8: Verify Dashboard view and data when logged in as a user with NO role.
     */
    public function test_dashboard_renders_fallback_view_for_roleless_user(): void
    {
        // Create user with no roles
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
        $response->assertViewMissing('user');
    }
}
