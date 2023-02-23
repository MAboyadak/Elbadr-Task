<?php 

namespace App\Repositories\Users;

interface UsersInterface
{
    function all();
    function store($request);
    function update($request, $id);
    function delete($id);
    function getByLocationAscending();
}