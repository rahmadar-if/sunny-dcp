<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Solaris\Core\Attributes\DataTableAccess;
use Solaris\Core\Attributes\FormAccess;
use Solaris\Core\Attributes\LookupAccess;
use Solaris\Core\Attributes\ExportAccess;
use Solaris\Core\Attributes\FolderAccess;
use Solaris\Core\Interfaces\Model\SolarisRoles;
use Solaris\Core\Interfaces\Model\SolarisUser;
use Solaris\Core\Traits\Model\HasSolarisUser;

#[FormAccess()]
#[LookupAccess(
    columnExceptions: ['password', 'remember_token']
)]
#[DataTableAccess(
    scopes: ['datatable'],
    columnExceptions: ['password', 'remember_token']
)]
#[FolderAccess(exclude: ['password', 'remember_token'])]
#[ExportAccess(exclude: ['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail, CanResetPassword, SolarisUser, SolarisRoles
{
    use HasFactory, HasSolarisUser;

    public function getDisplayValueName(): ?string
	{
		return "name";
	}

	public function getOrderBy(): string|array|null
	{
		return "username";
	}

	public function getDirection(): string
	{
		return "asc";
	}

	public function getPrepareColumns(): array
	{
		return ['id', 'name', 'email', 'username'];
	}

	public function getSearchColumns(): array
	{
		return ['name', 'email', 'username'];
	}

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'email_verified_at',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}