<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames   = config('permission.table_names');
        $columnNames  = config('permission.column_names');
        $teams        = config('permission.teams');
        $pivotRole    = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPerm    = $columnNames['permission_pivot_key'] ?? 'permission_id';

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not loaded.');
        }

        // ✅ Detect database driver
        $isMySql = Schema::getConnection()->getDriverName() === 'mysql';

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */
        Schema::create($tableNames['permissions'], function (Blueprint $table) use ($isMySql) {
            if ($isMySql) {
                $table->unsignedBigInteger('id', true);
            } else {
                $table->bigIncrements('id');
            }

            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        Schema::create($tableNames['roles'], function (Blueprint $table) use ($teams, $columnNames, $isMySql) {
            if ($isMySql) {
                $table->unsignedBigInteger('id', true);
            } else {
                $table->bigIncrements('id');
            }

            if ($teams || config('permission.testing')) {
                if ($isMySql) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                } else {
                    $table->bigInteger($columnNames['team_foreign_key'])->nullable();
                }

                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }

            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Model Has Permissions
        |--------------------------------------------------------------------------
        */
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use (
            $tableNames,
            $columnNames,
            $pivotPerm,
            $teams,
            $isMySql
        ) {
            if ($isMySql) {
                $table->unsignedBigInteger($pivotPerm);
                $table->unsignedBigInteger($columnNames['model_morph_key']);
            } else {
                $table->bigInteger($pivotPerm);
                $table->bigInteger($columnNames['model_morph_key']);
            }

            $table->string('model_type');

            if ($teams || config('permission.testing')) {
                if ($isMySql) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                } else {
                    $table->bigInteger($columnNames['team_foreign_key']);
                }

                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');

                $table->primary([
                    $columnNames['team_foreign_key'],
                    $pivotPerm,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'model_has_permissions_primary');
            } else {
                $table->primary([
                    $pivotPerm,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'model_has_permissions_primary');
            }

            $table->foreign($pivotPerm)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->index(
                [$columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_model_id_model_type_index'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Model Has Roles
        |--------------------------------------------------------------------------
        */
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use (
            $tableNames,
            $columnNames,
            $pivotRole,
            $teams,
            $isMySql
        ) {
            if ($isMySql) {
                $table->unsignedBigInteger($pivotRole);
                $table->unsignedBigInteger($columnNames['model_morph_key']);
            } else {
                $table->bigInteger($pivotRole);
                $table->bigInteger($columnNames['model_morph_key']);
            }

            $table->string('model_type');

            if ($teams || config('permission.testing')) {
                if ($isMySql) {
                    $table->unsignedBigInteger($columnNames['team_foreign_key']);
                } else {
                    $table->bigInteger($columnNames['team_foreign_key']);
                }

                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');

                $table->primary([
                    $columnNames['team_foreign_key'],
                    $pivotRole,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'model_has_roles_primary');
            } else {
                $table->primary([
                    $pivotRole,
                    $columnNames['model_morph_key'],
                    'model_type'
                ], 'model_has_roles_primary');
            }

            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->index(
                [$columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_model_id_model_type_index'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Role Has Permissions
        |--------------------------------------------------------------------------
        */
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use (
            $tableNames,
            $pivotRole,
            $pivotPerm,
            $isMySql
        ) {
            if ($isMySql) {
                $table->unsignedBigInteger($pivotPerm);
                $table->unsignedBigInteger($pivotRole);
            } else {
                $table->bigInteger($pivotPerm);
                $table->bigInteger($pivotRole);
            }

            $table->primary([$pivotPerm, $pivotRole], 'role_has_permissions_primary');

            $table->foreign($pivotPerm)
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');
        });

        app('cache')->forget('spatie.permission.cache');
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
