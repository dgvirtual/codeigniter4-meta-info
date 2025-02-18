# CodeIgniter4 Meta Info Library

CodeIgniter4 Meta Info library enables use of Entity-Attribute-Value style storage for additional data of entities
used with your models. It provides meta info functionality for CodeIgniter4, derived from [Bonfire2 project](https://github.com/lonnieezell/bonfire2).
It allows storing user-configurable bits of information for user entity classes without the need to modify
those classes.

[![PHPUnit](https://github.com/dgvirtual/codeigniter4-meta-info/actions/workflows/phpunit.yml/badge.svg)](https://github.com/dgvirtual/codeigniter4-meta-info/actions/workflows/phpunit.yml)
![Coverage](https://codecov.io/gh/dgvirtual/codeigniter4-meta-info/branch/develop/graph/badge.svg)
[![PHPStan](https://github.com/dgvirtual/codeigniter4-meta-info/actions/workflows/phpstan.yml/badge.svg)](https://github.com/dgvirtual/codeigniter4-meta-info/actions/workflows/phpstan.yml)

![PHP](https://img.shields.io/badge/PHP-%5E8.1-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-%5E4.5-blue)
[![GitHub license](https://github.com/dgvirtual/codeigniter4-meta-info)](https://github.com/dgvirtual/codeigniter4-meta-info/blob/develop/LICENSE)
[![contributions welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg?style=flat)](https://github.com/dgvirtual/codeigniter4-meta-info/pulls)


## Usage case

Imagine you have a users table to store data of users. It may be that it belongs to some package that
deals with users on your website. Suppose you need to add aditional fields to the user table to store additional
information, whether this is a bio, a website URL, social links, or anything else.

You can either change the main table each time you need such changes, or, alternatively, – store such data in
a separate table, without constantly changing the database schema.

Using this library you can add additional information to a user. Moreover, such data can be seamlessly integrated
into the Create/Edit User form so you do not have to modify that manually.

## Installation

To install this package, you can use Composer. Run the following commands in your terminal:

```cli
composer config minimum-stability dev
composer require dgvirtual/codeigniter4-meta-info
```

Then run the migration to setup the database table meta_info (assuming you already configured your database):

```cli
php spark migrate -n \Dgvirtual\MetaInfo
```

## Setup 1. Defining Meta Fields

If you want to get a functionality preview, you can enable the demo code (read the section [demo](#demo) below).

First you create a config class for your users table, `app/Config/Users.php`. Put a property `$metaFields` into
that class:

```php
public $metaFields = [
    'Social Links' => [
        'blog' => [
            'label' => 'Blog', // optional
            'type'  => 'text', // optional
            'validation' => 'permit_empty|valid_url_strict'
        ],
    ],
];
```

In the above example `Social links` is a subcategory that can later be used to build a categorized view for the
data; the key `type` corresponds to the field type (text, checkbox, etc.) in the view.

`blog` is the `column` for our data.

The other fields are used for data validation: `label` will act as label for validation rule and a label for
HTML input, and `validation` key => value pair will be transformed into a `rules` with validation rules as value.

## Setup 2. Adding Trait to your Entity class

Add the `HasMeta` trait and a protected `$configClass` property with a string value, the name of the above-mentioned
Config class containing `$metaFields` array, to the Entity class that represents your resource.

```php
use Dgvirtual\MetaInfo\Traits\HasMeta;
use CodeIgniter\Entity;

class User extends Entity
{
    use HasMeta;

    protected string $configClass = 'Users';
}
```

## Manipulating data

The User entity has a trait applied, `HasMeta`, that provides all the functionality you should need to work
with the meta information for that user.

### meta(string $key)

This returns the value of the user's meta named `$key`, or `null` if nothing has been set for that user.
The name is the key of the array mentioned above.

```php
$blog = $user->meta('blog');
```

### allMeta()

This returns all meta fields for this user. Note that it returns the full database results, not just the name/value.

```php
$meta = $user->allMeta();

var_dump($meta);

// Returns:
[
    'resource_id' => 123,
    'class' => 'App\Entities\User',
    'key' => 'blog',
    'value' => 'http://example.com',
    'created_at' => '2025-01-12 12:31:12',
    'updated_at' => '2025-01-12 12:31:12',
]
```

### hasMeta(string $key)

Used to check if a user has a value set for the given meta field.

```php
if ($user->hasMeta('foo')) {
    //
}
```

### saveMeta(string $key, $value)

Saves a single meta value to the user. This is immediately saved. There is no need to save the User through the UserModel.

```php
$url = $this->request->getPost('blog');
$user->saveMeta('blog', $url);
```

### deleteMeta(string $key)

Deletes a single meta value from the user. This is immediately deleted. There is no need to save the User through the UserModel.

```php
$user->deleteMeta('blog');
```

### deleteResourceMeta()

Deletes all meta info associated with an entity. To be used when purging a record.

```php
$user->deletResouceMeta();
```

### syncMeta(array $post)

Given an array of key/value pairs representing the name of the meta field and it's value, this will update existing
meta values, insert new ones, and delete any ones that were not passed in. Useful when grabbing the information from
a form and updating all the values at once.

```php
$post = [
    'blog' => 'http://example.com',
    'fb' => 'johnny.rose'
];
$user->syncMeta($post);
```

### metaValidationRules(string $prefix=null)

This examines the specified config file and returns an array with the names of each field and their validation rules,
ready to be used within CodeIgniter's validation library. If your form groups the name as an array, (like `meta[blog]`)
you may specify the prefix to append to the field names so that validation will pick it up properly.

```php
$rules = $user->metaValidationRules('meta');

var_dump($rules);

// Returns:
[
    'meta.blog' => 'required|string|valid_url',
]
```

## Using library for searches

You will want to get the data from meta_info table the same way you would from a related table, and,
for example, display it in search results.

Of course that is not as simple as when using a simple join.

To do that you will need to employ `WithMeta` trait in your model:

```php
namespace App\Models;

use App\Entities\User;
use CodeIgniter\Model;
use Dgvirtual\MetaInfo\Traits\WithMeta;

class UserModel extends Model
{
    use WithMeta;
```

Now you can use the methods provided by WithMeta to build queries. For example, you can
write the `search()` method in your model employing the trait methods
`generateMetaSelectClause`, `joinMetaInfo` and
`orLikeInMetaInfo()` when constructing the query; for example:

```php
public function search(string $term, int $limit = 100, int $offset = 0): array
{
    $termInMeta = config(\Config\Users::class)->includeMetaFieldsInSearch;

    // First: get the expanded select clause that includes info from meta_info table
    $selectClause = $this->generateMetaSelectClause($termInMeta, \App\Entities\User::class);

    $query = $this->select($selectClause)->distinct();

    if (!empty($termInMeta)) {
        // Second: generate the join statement
        // here the User::class is string representation of the entity class
        $query->joinMetaInfo(\App\Entities\User::class, $this->table);
    }

    if ($term) {
        $query->like('first_name', $term, 'right', true, true)
                ->orLike('last_name', $term, 'right', true, true)
                ->orLike('username', $term, 'right', true, true);

        if (!empty($termInMeta)) {
            foreach ($termInMeta as $metaField) {
                // Third: perform the search through like statements
                $query->orLikeInMetaInfo($metaField, $term, 'both', true, true);
            }
        }
    }

    return $query->findAll($limit, $offset);
}
```

This method can now be used in controllers to perform searches and get information with data from
meta_info table neatly integrated into the data from the main table.

## Demo

A demo is provided with this library. Enabling demo would create a table `testusers` in your DB, which you can remove later.

Steps to enable the demo:

1. update Config\Autoload file to include demo namespace into the list of available namespaces:

    ```php
    public $psr4 = [
        APP_NAMESPACE        => APPPATH,
        'Dgvirtual\Demo'     => APPPATH . 'vendor/dgvirtual/codeigniter4-meta-info/demo',
    ];
    ```

2. Add the table with demo data via migrations and seed it with demo data:

    ```cli
    php spark migrate -n \Dgvirtual\Demo
    php spark db:seed \Tests\Support\Database\Seeds\TestusersSeeder
    ```

3. Copy this into your Config\Routes.php file:

    ```php
    $routes->group('testusers', ['namespace' => 'Dgvirtual\Demo\Controllers'], static function ($routes) {
        $routes->get('/', 'TestusersController::index');
        $routes->get('create', 'TestusersController::create');
        $routes->get('edit/(:num)', 'TestusersController::edit/$1');
        $routes->post('save', 'TestusersController::save');
        $routes->post('save/(:num)', 'TestusersController::save/$1');
        $routes->post('delete/(:num)', 'TestusersController::delete/$1');
        $routes->cli('testing/(:num)', 'TestusersController::testing/$1');
    });
    ```

Now you can open the demo at https://localhost:8080/testusers

To disable the demo, please undo the above-mentioned changes in files. To remove the demo table, use
Codeigniter4 [migration rollback functionality](https://codeigniter4.github.io/userguide/dbmgmt/migration.html#migrate-rollback).

## Contributing

If you would like to contribute to this project, please fork the repository and submit a pull request.

## Credits

This library is an adaptation of Bonfire2 Users meta info functionality for
general CodeIgniter 4 use. Bonfire2 was created by Lonnie Ezell
<lonnieje@gmail.com> and contributors. For more information, visit the
[Bonfire2 project](https://github.com/lonnieezell/Bonfire2).

This library was created by Donatas Glodenis. You can reach out to
me at [dg@lapas.info] for any questions or feedback.

## License

This project is licensed under the MIT License. See the LICENSE file for
details.
