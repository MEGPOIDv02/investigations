<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int $fk_id_role
 *
 * @property Role $role
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    const ADMIN=1;
    const STUDENT=2;
	protected $table = 'users';

	protected $casts = [
		'active' => 'bool',
		'fk_id_role' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'password',
		'active',
		'remember_token',
		'fk_id_role'
	];

	public function role()
	{
		return $this->belongsTo(Role::class, 'fk_id_role');
	}
}
