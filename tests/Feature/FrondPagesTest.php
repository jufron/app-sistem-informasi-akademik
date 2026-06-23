<?php

namespace Tests\Feature;

use App\Http\Controllers\PagesController;
use Illuminate\View\View;
use ReflectionClass;
use Tests\TestCase;

class FrondPagesTest extends TestCase
{
    /**
     * Test 1: Verify the controller class exists, matches the expected namespace and name,
     * and inherits from the correct base controller.
     */
    public function test_controller_class_name_and_inheritance(): void
    {
        $controllerClass = PagesController::class;

        // Check if class exists
        $this->assertTrue(class_exists($controllerClass), "PagesController class does not exist.");

        // Check namespace and class name match
        $this->assertEquals('App\Http\Controllers\PagesController', $controllerClass);

        // Check if class base name is exactly PagesController
        $reflection = new ReflectionClass($controllerClass);
        $this->assertEquals('PagesController', $reflection->getShortName(), "The controller class name is not correct.");

        // Check inheritance from App\Http\Controllers\Controller
        $this->assertTrue(
            is_subclass_of($controllerClass, 'App\Http\Controllers\Controller'),
            "PagesController must extend App\Http\Controllers\Controller."
        );
    }

    /**
     * Test 2: Verify that the required methods are defined in the PagesController class.
     */
    public function test_controller_has_required_methods(): void
    {
        $controllerClass = PagesController::class;
        $requiredMethods = [
            'index',
            'tentang',
            'guruDanPengajar',
            'kontak',
            'detailGuruDanStaf'
        ];

        $reflection = new ReflectionClass($controllerClass);

        foreach ($requiredMethods as $methodName) {
            $this->assertTrue(
                $reflection->hasMethod($methodName),
                "Method '{$methodName}' is missing in PagesController."
            );

            // Verify method is public
            $method = $reflection->getMethod($methodName);
            $this->assertTrue(
                $method->isPublic(),
                "Method '{$methodName}' in PagesController must be public."
            );
        }
    }

    /**
     * Test 3: Unit-level verification of controller methods to ensure they return the correct view.
     * By invoking the methods directly, we check if they return the intended View.
     */
    public function test_controller_methods_return_correct_views_directly(): void
    {
        $controller = $this->app->make(PagesController::class);

        // 1. index method -> frond.home
        $view = $controller->index();
        $this->assertInstanceOf(View::class, $view, "index method did not return a View instance.");
        $this->assertEquals('frond.home', $view->name(), "index method did not return 'frond.home' view.");

        // 2. tentang method -> frond.tentang
        $view = $controller->tentang();
        $this->assertInstanceOf(View::class, $view, "tentang method did not return a View instance.");
        $this->assertEquals('frond.tentang', $view->name(), "tentang method did not return 'frond.tentang' view.");

        // 3. guruDanPengajar method -> frond.guruDanPengajar
        $view = $controller->guruDanPengajar();
        $this->assertInstanceOf(View::class, $view, "guruDanPengajar method did not return a View instance.");
        $this->assertEquals('frond.guruDanPengajar', $view->name(), "guruDanPengajar method did not return 'frond.guruDanPengajar' view.");

        // 4. kontak method -> frond.kontak
        $view = $controller->kontak();
        $this->assertInstanceOf(View::class, $view, "kontak method did not return a View instance.");
        $this->assertEquals('frond.kontak', $view->name(), "kontak method did not return 'frond.kontak' view.");

        // 5. detailGuruDanStaf method -> frond.detailGuruDanStaf
        $view = $controller->detailGuruDanStaf();
        $this->assertInstanceOf(View::class, $view, "detailGuruDanStaf method did not return a View instance.");
        $this->assertEquals('frond.detailGuruDanStaf', $view->name(), "detailGuruDanStaf method did not return 'frond.detailGuruDanStaf' view.");
    }

    /**
     * Test 4: Feature-level verification to ensure that HTTP requests invoke these controller methods
     * through the router and return the expected response and view.
     */
    public function test_routes_invoke_controller_methods_and_render_correct_views(): void
    {
        // Define route configurations to be verified
        $routeAssertions = [
            [
                'url' => '/',
                'name' => 'frond.home',
                'view' => 'frond.home',
                'action' => 'index'
            ],
            [
                'url' => '/tentang',
                'name' => 'frond.tentang',
                'view' => 'frond.tentang',
                'action' => 'tentang'
            ],
            [
                'url' => '/guru-dan-staf',
                'name' => 'frond.guru-dan-staf',
                'view' => 'frond.guruDanPengajar',
                'action' => 'guruDanPengajar'
            ],
            [
                'url' => '/kontak',
                'name' => 'frond.kontak',
                'view' => 'frond.kontak',
                'action' => 'kontak'
            ],
            [
                'url' => '/detail-guru-dan-staf',
                'name' => 'frond.guru-dan-staf.show',
                'view' => 'frond.detailGuruDanStaf',
                'action' => 'detailGuruDanStaf'
            ]
        ];

        foreach ($routeAssertions as $assert) {
            // Verify URL resolves properly and yields successful response (200 OK)
            $response = $this->get($assert['url']);
            $response->assertStatus(200);
            $response->assertViewIs($assert['view']);

            // Verify Route name resolves to the correct URL
            $this->assertEquals(url($assert['url']), route($assert['name']), "Route name '{$assert['name']}' does not resolve to the correct URL.");

            // Verify that the route actually uses the correct controller and action method
            $currentRoute = app('router')->getRoutes()->getByName($assert['name']);
            $this->assertNotNull($currentRoute, "Route name '{$assert['name']}' is not registered.");
            
            $actionName = $currentRoute->getActionName();
            $expectedAction = PagesController::class . '@' . $assert['action'];
            $this->assertEquals($expectedAction, $actionName, "Route '{$assert['name']}' is not mapped to the expected controller action: '{$expectedAction}'");
        }
    }
}
