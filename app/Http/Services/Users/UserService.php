<?php

namespace App\Http\Services\Users;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use Exception;

use App\Models\{User};

class UserService
{
    /**
     * @var
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUsers() : Collection
    {
        try {
            $users = $this->user->all();
            return $users;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getById($id) : User | null
    {
        try {
            $user = $this->user->find($id);
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function filter($email) : User | null
    {
        try {
            $user = $this->user->where('email', $email)->first();
            return $user;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($data) : User
    {
        //Insert Record
        //---------------------------------------------------
        DB::beginTransaction();
            $record = $this->user->create($data);
        DB::commit();
        //---------------------------------------------------

        return $record;
    }

    public function login($user) : String
    {
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function delete(int $id): bool
    {
        //Delete Record
        //-------------------------------------------------------
        DB::beginTransaction();
            $record = self::getById($id);
            $record->delete();
        DB::commit();
        //-------------------------------------------------------

        return true;
    }
}