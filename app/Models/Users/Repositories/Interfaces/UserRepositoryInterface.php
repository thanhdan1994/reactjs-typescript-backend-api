<?php
namespace App\Models\Users\Repositories\Interfaces;

use App\Models\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;
}