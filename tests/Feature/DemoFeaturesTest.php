<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Config\Services;
use Dgvirtual\Demo\Controllers\TestusersController;
use Dgvirtual\Demo\Entities\Testuser;
use Tests\Support\Database\Seeds\MetaInfoSeeder;
use Tests\Support\Database\Seeds\TestusersSeeder;
use Tests\Support\DatabaseHelperTrait;

/**
 * @internal
 */
final class DemoFeaturesTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use DatabaseHelperTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $namespace   = [
        'Dgvirtual\Demo',
        'Dgvirtual\MetaInfo',
    ];
    protected $seedOnce = false;
    protected $seed     = [
        TestusersSeeder::class,
        MetaInfoSeeder::class,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // Define the routes needed for the tests
        $routes = Services::routes();

        // Define the routes needed for the tests
        $routes = Services::routes();
        $routes->get('testusers', [TestusersController::class, 'index']);
        $routes->get('testusers/create', [TestusersController::class, 'create']);
        $routes->get('testusers/edit/(:num)', [TestusersController::class, 'edit/$1']);
        $routes->post('testusers/save', [TestusersController::class, 'save']);
        $routes->post('testusers/save/(:num)', [TestusersController::class, 'save/$1']);
        $routes->post('testusers/delete/(:num)', [TestusersController::class, 'delete/$1']);
    }

    public function testIndex()
    {
        $result = $this->call('GET', 'testusers');

        $result->assertStatus(200);
        $result->assertSee('<h1>Users List</h1>');
    }

    public function testCreate()
    {
        $result = $this->get('testusers/create');

        $result->assertStatus(200);
        $result->assertSee('<h1>Create User</h1>');
    }

    public function testEdit()
    {
        $result = $this->get('testusers/edit/1');

        $result->assertStatus(200);
        $result->assertSee('<h1>Edit User</h1>');
        $result->assertSee('Mafalda');
    }

    public function testSaveNew()
    {
        $data = [
            'username'   => 'testuser',
            'first_name' => 'Test',
            'last_name'  => 'User',
            'meta'       => [
                'blog' => 'https://mynewblog.example.com',
            ],
        ];

        $result = $this->post('testusers/save', $data);

        $result->assertRedirectTo('/testusers');

        // Check if the database contains the new entry
        $this->seeInDatabase('testusers', [
            'username'   => 'testuser',
            'first_name' => 'Test',
            'last_name'  => 'User',
        ]);

        // $this->printTableContent('meta_info');
        // dd();

        // Check if the meta information is saved correctly
        $this->seeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => 12, // manual!
            'key'         => 'blog',
            'value'       => 'https://mynewblog.example.com',
        ]);
    }

    public function testSaveNewFailValidation()
    {
        $data = [
            'username'   => '',
            'first_name' => 'TestInvalid',
            'last_name'  => 'UserInvalid',
            'meta'       => [
                'blog' => 'https://blog1.example.com',
            ],
        ];

        $result = $this->post('testusers/save', $data);

        // $result->assertRedirectTo('/testusers/create/');

        // Check if the database contains the new entry
        $this->dontSeeInDatabase('testusers', [
            'first_name' => 'TestInvalid',
            'last_name'  => 'UserInvalid',
        ]);
    }

    public function testSaveExisting()
    {
        $data = [
            'username'   => 'testuser22',
            'first_name' => 'Test22',
            'last_name'  => 'User22',
            'meta'       => [
                'blog' => 'https://blog22.example.com',
            ],
        ];

        $result = $this->post('testusers/save/1', $data);

        $result->assertRedirectTo('/testusers');

        // Check if the database contains the new entry
        $this->seeInDatabase('testusers', [
            'id'         => 1,
            'username'   => 'testuser22',
            'first_name' => 'Test22',
            'last_name'  => 'User22',
        ]);

        // $this->printTableContent('meta_info');
        // dd();

        // Check if the meta information is saved correctly
        $this->seeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => 1, // manual!
            'key'         => 'blog',
            'value'       => 'https://blog22.example.com',
        ]);
    }

    public function testDelete()
    {
        $result = $this->post('testusers/delete/1');

        $result->assertRedirectTo('/testusers');

        // Check if the user is deleted from the database
        $this->dontSeeInDatabase('testusers', ['id' => 1]);

        // Check if the meta information is deleted from the database
        $this->dontSeeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => 1,
        ]);
    }
}
