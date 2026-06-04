<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('payroll')) {
            return;
        }

        Schema::table('payroll', function (Blueprint $table) {
            if (Schema::hasColumn('payroll', 'cut_off_start')) {
                $table->date('cut_off_start')->nullable()->change();
            }

            if (Schema::hasColumn('payroll', 'cut_off_end')) {
                $table->date('cut_off_end')->nullable()->change();
            }

            if (!Schema::hasColumn('payroll', 'paid_date')) {
                $table->date('paid_date')->nullable()->after('employee_id');
            }

            if (!Schema::hasColumn('payroll', 'present_days')) {
                $table->unsignedTinyInteger('present_days')->default(0)->after('cut_off_end');
            }

            if (!Schema::hasColumn('payroll', 'absent_days')) {
                $table->unsignedTinyInteger('absent_days')->default(0)->after('present_days');
            }

            if (!Schema::hasColumn('payroll', 'late_days')) {
                $table->unsignedTinyInteger('late_days')->default(0)->after('absent_days');
            }

            if (!Schema::hasColumn('payroll', 'late_deduction')) {
                $table->decimal('late_deduction', 10, 2)->default(0)->after('gross_pay');
            }

            if (!Schema::hasColumn('payroll', 'selected_deductions')) {
                $table->text('selected_deductions')->nullable()->after('late_deduction');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('payroll')) {
            return;
        }

        Schema::table('payroll', function (Blueprint $table) {
            $columns = collect([
                'paid_date',
                'present_days',
                'absent_days',
                'late_days',
                'late_deduction',
                'selected_deductions',
            ])->filter(fn ($column) => Schema::hasColumn('payroll', $column))->all();

            if ($columns) {
                $table->dropColumn($columns);
            }

            if (Schema::hasColumn('payroll', 'cut_off_start')) {
                $table->date('cut_off_start')->nullable(false)->change();
            }

            if (Schema::hasColumn('payroll', 'cut_off_end')) {
                $table->date('cut_off_end')->nullable(false)->change();
            }
        });
    }
};
