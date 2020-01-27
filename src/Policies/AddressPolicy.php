<?php

namespace Softworx\RocXolid\Common\Policies;

use Debugbar;
use Illuminate\Auth\Access\HandlesAuthorization;
// rocXolid utils
use Softworx\RocXolid\Http\Requests\CrudRequest;
// rocXolid model contracts
use Softworx\RocXolid\Models\Contracts\Crudable;
// rocXolid user management models
use Softworx\RocXolid\UserManagement\Models\User;

class AddressPolicy
{
    use HandlesAuthorization;

    protected $request;

    public function __construct(CrudRequest $request)
    {
        Debugbar::debug(__METHOD__, $request);
        Debugbar::debug(__METHOD__, $request->route());
        $this->request = $request;
    }

    /**
     * Determine whether the user can view any resources.
     *
     * @param \App\User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        Debugbar::debug(__METHOD__, $user);
        return true;
    }

    /**
     * Determine whether the user can view the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function view(User $user, Crudable $model): bool
    {
        Debugbar::debug(__METHOD__, $user, $model);
        return true;
    }

    /**
     * Determine whether the user can create resource.
     *
     * @param \App\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        Debugbar::debug(__METHOD__, $user);
        Debugbar::debug(__METHOD__, $this->request->route());
        return true;
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function update(User $user, Crudable $model): bool
    {
        Debugbar::debug(__METHOD__, $user, $model);
        return true;
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param \App\User $user
     * @param \App\WorkLog $model
     * @return bool
     */
    public function delete(User $user, Crudable $model): bool
    {
        Debugbar::debug(__METHOD__, $user, $model);
        return true;
    }
}
