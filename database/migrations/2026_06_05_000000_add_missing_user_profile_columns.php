<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'employee_id')) {
                $table->unsignedBigInteger('employee_id')->nullable()->after('id')->index();
            }

            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('employee_id');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $columns = collect([
                'name',
                'employee_id',
            ])->filter(fn ($column) => Schema::hasColumn('users', $column))->all();

            if ($columns) {
                $table->dropColumn($columns);
            }
        });
    }
};
