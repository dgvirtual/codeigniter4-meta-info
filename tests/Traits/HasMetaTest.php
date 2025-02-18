<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * Significant part of the code is adapted from Bonfire2
 * project, (c) Lonnie Ezell <lonnieje@gmail.com>
 */

// The below is not adapted to this library yet

namespace Tests\Traits;

use CodeIgniter\Config\Factories;
use CodeIgniter\Test\DatabaseTestTrait;
use Dgvirtual\Demo\Entities\Testuser;
use Dgvirtual\Demo\Models\TestuserModel;
use Tests\Support\DatabaseTestCase;

/**
 * @internal
 */
final class HasMetaTest extends DatabaseTestCase
{
    use DatabaseTestTrait;

    protected $namespace;

    /**
     * @var User
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // $user = model(TestuserModel::class)->first();
        // dd($user);

        $this->user = new Testuser();
        $this->user->fill([
            'username'   => 'walker',
            'first_name' => 'Minnie',
            'last_name'  => 'Thiel',
        ]);
        model(TestuserModel::class)->insert($this->user);
        $this->user->id = model(TestuserModel::class)->getInsertID();

        // Ensure we have some fields to test against.
        $config             = config('Testusers');
        $config->metaFields = [
            'Example Fields' => [
                'foo' => [
                    'label'      => 'Foo',
                    'type'       => 'text',
                    'validation' => 'permit_empty|string',
                ],
                'Bar' => [
                    'type'       => 'text',
                    'required'   => true,
                    'validation' => 'required|string',
                ],
            ],
        ];
        Factories::injectMock('config', 'Testusers', $config);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->user);
    }

    private function addSomeMeta()
    {
        $this->user->saveMeta('foo', 'Some great info foo');
        $this->user->saveMeta('Bar', 'Some great info Bar');
        $this->user->saveMeta('baz', 'Some great info BAZZ');
    }

    public function testSaveMetaOnNew()
    {
        $this->assertFalse($this->user->hasMeta('foo'));
        $this->assertNull($this->user->meta('bar'));

        $this->user->saveMeta('foo', 'Some great info here');
        $this->assertTrue($this->user->hasMeta('foo'));
        $this->assertSame('Some great info here', $this->user->meta('foo'));

        $this->seeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => $this->user->id,
            'key'         => 'foo',
            'value'       => 'Some great info here',
        ]);
    }

    public function testSaveMetaOnExisting()
    {
        // do not use the default entity from setUp()
        $user = model(TestuserModel::class)->find(1);

        $newBlog = 'https://blog.example.com';
        $user->saveMeta('blog', $newBlog);

        $this->assertTrue($user->hasMeta('blog'));

        $this->seeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => 1,
            'key'         => 'blog',
            'value'       => $newBlog,
        ]);
    }

    public function testAllMetaKeyValue()
    {
        $this->user->saveMeta('foo', 'First piece of info');
        $this->user->saveMeta('bar', 'Some other piece of info');
        $result = $this->user->allMetaKeyValue();
        $this->assertIsArray($result);
        $this->assertSame($result['bar'], 'Some other piece of info');
    }

    public function testMetaOneKey()
    {
        $value = 'Some great different info here';
        $this->user->saveMeta('foo', $value);
        // check
        $this->assertSame($this->user->meta('foo'), $value);
    }

    public function testDeleteMeta()
    {
        // Setup
        $value = 'Some great different info here';
        $this->user->saveMeta('foo', $value);

        // check
        $this->assertSame($this->user->meta('foo'), $value);

        // Teardown
        $this->user->deleteMeta('foo');
        $this->assertFalse($this->user->hasMeta('foo'));
        $this->dontSeeInDatabase('meta_info', [
            'class'       => Testuser::class,
            'resource_id' => $this->user->id,
            'key'         => 'foo',
        ]);

        // Shouldn't crash when key doesn't exist
        $this->user->deleteMeta('abcdefg');
    }

    public function testDeleteResourceMeta()
    {
        $this->addSomeMeta();
        $this->assertIsArray($this->user->allMeta());
        $this->assertCount(3, $this->user->allMeta());
        $this->user->deleteResourceMeta();
        $this->assertNull($this->user->allMeta());
    }

    public function testSyncMeta()
    {
        $this->assertFalse($this->user->hasMeta('foo'));

        // Insert new value from empty state
        $this->user->syncMeta(['foo' => 'aaa']);

        $this->assertTrue($this->user->hasMeta('foo'));
        $this->assertSame('aaa', $this->user->meta('foo'));

        // Update the value
        $this->user->syncMeta(['foo' => 'bbb']);
        $this->assertTrue($this->user->hasMeta('foo'));
        $this->assertSame('bbb', $this->user->meta('foo'));

        // Delete the value with empty string
        $this->user->syncMeta(['foo' => '']);
        $this->assertFalse($this->user->hasMeta('foo'));
    }

    public function testSyncMetaWithNull()
    {
        $this->assertFalse($this->user->hasMeta('foo'));

        // Insert new value from empty state
        $this->user->syncMeta(['foo' => 'aaa']);

        // Delete the value with NULL
        $this->user->syncMeta(['foo' => null]);
        $this->assertFalse($this->user->hasMeta('foo'));
    }

    public function testMetaValidationRules()
    {
        // Ensure we have some fields to test against.
        $config             = config('Testusers');
        $config->metaFields = [
            'Example Fields' => [
                'foo' => [
                    'label'      => 'Foo',
                    'type'       => 'text',
                    'validation' => 'permit_empty|string',
                ],
                'bar' => [
                    'label'      => 'Bar',
                    'type'       => 'text',
                    'validation' => 'required|string',
                ],
                'baz' => [
                    'label'      => 'Baz',
                    'type'       => 'number',
                    'validation' => 'required|integer',
                ],
            ],
        ];
        Factories::injectMock('config', 'Testusers', $config);

        // Test without prefix
        $rules         = $this->user->metaValidationRules();
        $expectedRules = [
            'foo' => [
                'label' => 'Foo',
                'rules' => 'permit_empty|string',
            ],
            'bar' => [
                'label' => 'Bar',
                'rules' => 'required|string',
            ],
            'baz' => [
                'label' => 'Baz',
                'rules' => 'required|integer',
            ],
        ];
        $this->assertSame($expectedRules, $rules);

        // Test with prefix
        $prefix                  = 'meta';
        $rulesWithPrefix         = $this->user->metaValidationRules($prefix);
        $expectedRulesWithPrefix = [
            'meta.foo' => [
                'label' => 'Foo',
                'rules' => 'permit_empty|string',
            ],
            'meta.bar' => [
                'label' => 'Bar',
                'rules' => 'required|string',
            ],
            'meta.baz' => [
                'label' => 'Baz',
                'rules' => 'required|integer',
            ],
        ];
        $this->assertSame($expectedRulesWithPrefix, $rulesWithPrefix);

        // Additional tests to cover all lines
        // Test with different prefix
        $prefix                        = 'custom';
        $rulesWithCustomPrefix         = $this->user->metaValidationRules($prefix);
        $expectedRulesWithCustomPrefix = [
            'custom.foo' => [
                'label' => 'Foo',
                'rules' => 'permit_empty|string',
            ],
            'custom.bar' => [
                'label' => 'Bar',
                'rules' => 'required|string',
            ],
            'custom.baz' => [
                'label' => 'Baz',
                'rules' => 'required|integer',
            ],
        ];
        $this->assertSame($expectedRulesWithCustomPrefix, $rulesWithCustomPrefix);

        // Test with empty metaFields
        $config->metaFields = [];
        Factories::injectMock('config', 'Testusers', $config);
        $rules = $this->user->metaValidationRules();
        $this->assertEmpty($rules);

        // Test with null metaFields
        $config->metaFields = null;
        Factories::injectMock('config', 'Testusers', $config);
        $rules = $this->user->metaValidationRules();
        $this->assertEmpty($rules);
    }

    public function testMetaValidationRulesWithEmptyMetaFields()
    {
        // Ensure we have some fields to test against.
        $config             = config('Testusers');
        $config->metaFields = [];
        Factories::injectMock('config', 'Testusers', $config);

        $rules = $this->user->metaValidationRules();
        $this->assertEmpty($rules);

        // Ensure we have some fields to test against.
        $config             = config('Testusers');
        $config->metaFields = [
            'Example Fields' => [
                'foo' => [],
                'bar' => [
                    'label'      => 'Bar',
                    'type'       => 'text',
                    'validation' => 'required|string',
                ],
                'baz' => [
                    'label'      => 'Baz',
                    'type'       => 'number',
                    'validation' => 'required|integer',
                ],
            ],
        ];
        Factories::injectMock('config', 'Testusers', $config);

        // Test without prefix
        $rules         = $this->user->metaValidationRules();
        $expectedRules = [
            // 'foo' => [], this should be skipped
            'bar' => [
                'label' => 'Bar',
                'rules' => 'required|string',
            ],
            'baz' => [
                'label' => 'Baz',
                'rules' => 'required|integer',
            ],
        ];
        $this->assertSame($expectedRules, $rules);
    }
}
