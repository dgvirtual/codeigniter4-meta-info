<?php

/**
 * This file is part of the codeigniter4-meta-info library.
 * (c) Donatas Glodenis <dg@lapas.info>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Dgvirtual\Demo\Controllers;

use CodeIgniter\Controller;
use Dgvirtual\Demo\Entities\Testuser;
use Dgvirtual\Demo\Models\TestuserModel;

/**
 * Class TestusersController
 */
class TestusersController extends Controller
{
    public $model;

    /**
     * TestusersController constructor.
     */
    public function __construct()
    {
        helper('form');
        $this->model = model(TestuserModel::class);
    }

    /**
     * List users.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function index()
    {
        $term = $this->request->getGet('term') ?? '';

        $data['users'] = $this->model->search($term);
        $data['term']  = $term;

        return view('Dgvirtual\Demo\testusers\index', $data);
    }

    /**
     * Show create form.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function create()
    {
        return view('Dgvirtual\Demo\testusers\create', [
            'errors' => service('session')->getFlashData('errors'),
        ]);
    }

    /**
     * Show edit form.
     *
     * @param int $id
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function edit($id)
    {
        $user       = $this->model->find($id);
        $user->meta = $user->allMetaKeyValue() ?? [];

        return view('Dgvirtual\Demo\testusers\edit', [
            'user'   => $user,
            'errors' => service('session')->getFlashData('errors'),
        ]);
    }

    /**
     * Store or update user.
     *
     * @param int|null $id
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function save($id = null)
    {
        $user = $id !== null
            ? $this->model->find($id)
            : new Testuser();

        // merge and set rules
        service('validation')->setRules(
            array_merge(
                $this->model->validationRules,
                $user->metaValidationRules('meta'),
            ),
        );

        if (! service('validation')->run($this->request->getPost())) {
            return redirect()->back()->withInput();
        }

        $data = service('validation')->getValidated();
        $meta = $data['meta'] ?? [];
        unset($data['meta']);

        $user->fill($data);

        if (! $user->hasChanged()) {
            $user->syncMeta($meta);
        } elseif ($this->model->save($user)) {
            $user->id ??= $this->model->getInsertID();
            $user->syncMeta($meta);
        } else {
            return redirect()->back()->withInput();
        }

        return redirect()->to('/testusers');
    }

    /**
     * Delete user.
     *
     * @param int $id
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete($id)
    {
        $user = $this->model->find($id);

        if ($user) {
            $user->deleteResourceMeta();
            $this->model->delete($id);
        }

        return redirect()->to('/testusers');
    }

}
