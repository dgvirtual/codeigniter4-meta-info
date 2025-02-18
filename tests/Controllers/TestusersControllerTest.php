<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Dgvirtual\Demo\Controllers\TestusersController;
use Tests\Support\Database\Seeds\MetaInfoSeeder;
use Tests\Support\Database\Seeds\TestusersSeeder;
use Tests\Support\DatabaseHelperTrait;

/**
 * @internal
 */
final class TestusersControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;
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
    protected $basePath = SUPPORTPATH . 'Database/';

    public function testIndex()
    {
        $result = $this->withURI('http://example.com/testusers')
            ->controller(TestusersController::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('<h1>Users List</h1>', $result->getBody());
    }

    public function testCreate()
    {
        $result = $this->withURI('http://example.com/testusers/create')
            ->controller(TestusersController::class)
            ->execute('create');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('<h1>Create User</h1>', $result->getBody());
    }

    public function testEdit()
    {
        $result = $this->withURI('http://example.com/testusers/edit/1')
            ->controller(TestusersController::class)
            ->execute('edit', 1);

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('<h1>Edit User</h1>', $result->getBody());
        $this->assertStringContainsString('Mafalda', $result->getBody());
    }

    // Maybe revisit after getting a better grasp on controller testing
    // public function testSaveNew()
    // {
    //     $data = [
    //         'username'   => 'testuser',
    //         'first_name' => 'Test',
    //         'last_name'  => 'User',
    //         'meta'       => [
    //             'blog' => 'https://mynewblog.example.com',
    //         ],
    //     ];

    //     $request = new \CodeIgniter\HTTP\IncomingRequest(
    //         new \Config\App(),
    //         new \CodeIgniter\HTTP\URI('http://example.com/testusers/save'),
    //         null,
    //         new \CodeIgniter\HTTP\UserAgent()
    //     );

    //     $request->setMethod('post');
    //     $request->setGlobal('post', $data);

    //     $result = $this->withRequest($request)
    //         ->controller(TestusersController::class)
    //         ->execute('save');

    //     // Print the content of the testusers table
    //     $this->printTableContent('testusers');

    //     // Check if the database contains the new entry
    //     $this->seeInDatabase('db_testusers', [
    //         'username'   => 'testuser',
    //         'first_name' => 'Test',
    //         'last_name'  => 'User',
    //     ]);

    //     // Check if the meta information is saved correctly
    //     $this->seeInDatabase('meta_info', [
    //         'class'       => \Dgvirtual\Demo\Entities\Testuser::class,
    //         'resource_id' => 1, // Assuming the new user gets ID 1
    //         'key'         => 'blog',
    //         'value'       => 'https://mynewblog.example.com',
    //     ]);

    //     $this->assertTrue($result->isRedirect());
    //     $this->assertStringContainsString('/testusers', $result->getRedirectUrl());
    // }
}
