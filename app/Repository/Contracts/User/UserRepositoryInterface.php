<?php

namespace App\Repository\Contracts\User;

interface UserRepositoryInterface
{
    public function getAll($perPage = 10, $search = null, $status = null);
    public function count();
    public function latest();
    public function countActive();
    public function get($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
