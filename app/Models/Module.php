<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';
    protected $fillable = [ 'name' ];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];

    public function menus()
    {
    	return $this->hasMany(Menu::class, 'module_id');
    }

    // Check role has any permission
    public function hasAnyPermission($role_id)
    {
    	$role = Role::find($role_id);
    	$permissions = $role->permissions->pluck('name')->toArray();
    	$menus = $this->menus->pluck('permission')->toArray();
    	return !empty(array_intersect($menus, $permissions));
    }
}
