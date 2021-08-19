<?php
namespace App\Models\Users\Repositories;

use App\Models\BaseRepository;
use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Collection;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
        $this->model = $user;
    }

    public function listUsers(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection
    {
        return $this->all($columns, $order, $sort);
    }
}