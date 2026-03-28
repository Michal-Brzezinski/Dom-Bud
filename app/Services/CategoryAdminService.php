<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Core\Database;

class CategoryAdminService
{
    private CategoryRepository $repo;

    public function __construct()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $pdo = Database::getConnection($config['db']);
        $this->repo = new CategoryRepository($pdo);
    }

    public function all()
    {
        return $this->repo->getAll();
    }

    public function find(int $id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}
