<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Module extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'modules';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'order_level'
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 
        'created_at',
        'updated_at'
    ];

    public function menus()
    {
    	return $this->hasMany(Menu::class, 'module_id');
    }

    /**
     * Check role ha any permission.
     *
     * @param int $role_id
     */
    public function hasAnyPermission($role_id)
    {
    	$role = Role::find($role_id);
    	$permissions = $role->permissions->pluck('name')->toArray();
    	$menus = $this->menus->pluck('permission')->toArray();
    	return !empty(array_intersect($menus, $permissions));
    }
}
