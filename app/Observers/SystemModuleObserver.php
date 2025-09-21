<?php

namespace App\Observers;

use App\Models\SystemModule;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class SystemModuleObserver
{
    /**
     * Handle the SystemModule "created" event.
     */
    public function created(SystemModule $module): void
    {
        $actions = ['view','create','edit','delete','export','edit_all'];

        foreach ($actions as $action) {
            $perm = Permission::firstOrCreate(
                [
                    'name' => "{$module->permission_key}.{$action}",
                    'guard_name' => 'web',
                ] 
            );

            Log::info("Permission created", ['permission' => $perm->name]);
        }
    }

    /**
     * Handle the SystemModule "updated" event.
     */
    public function updated(SystemModule $module): void
    {
        if ($module->wasChanged('permission_key')) {
            $oldKey = $module->getOriginal('permission_key');
            $newKey = $module->permission_key;
            $actions = ['view','create','edit','delete','export','edit_all'];

            foreach ($actions as $action) {
                $oldName = "{$oldKey}.{$action}";
                $newName = "{$newKey}.{$action}";

                $permission = Permission::where('name', $oldName)->first();

                if ($permission) {
                    $permission->update(['name' => $newName]);
                    Log::info("Permission renamed", [
                        'from' => $oldName,
                        'to'   => $newName
                    ]);
                } else {
                    $perm = Permission::firstOrCreate([
                        'name'       => $newName,
                        'guard_name' => 'web',
                    ]);
                    Log::info("Permission created (missing)", [
                        'permission' => $perm->name
                    ]);
                }
            }
        }
    }
 

    /**
     * Handle the SystemModule "deleted" event.
     */
    public function deleted(SystemModule $systemModule): void
    {
        //
    }

    /**
     * Handle the SystemModule "restored" event.
     */
    public function restored(SystemModule $systemModule): void
    {
        //
    }

    /**
     * Handle the SystemModule "force deleted" event.
     */
    public function forceDeleted(SystemModule $systemModule): void
    {
        //
    }
}
