<?php

namespace App\Repositorties;

interface RepositoryInterface
{
    public function baseQuery($relations = []);
    public function getById($id);
    public function store($request);
    public function update($id, $request);
    public function delete($request);
}
