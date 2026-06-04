<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll', function (Blueprint $table) {
            $table->date('cut_off_start')->nullable()->change();
            $table->date('cut_off_end')->nullable()->change();

            $table->date('paid_date')->nullable()->after('employee_id');

            $table->unsignedTinyInteger('present_days')->default(0)->after('cut_off_end');
            $table->unsignedTinyInteger('absent_days')->default(0)->after('present_days');
            $table->unsignedTinyInteger('late_days')->default(0)->after('absent_days');

            $table->decimal('late_deduction', 10, 2)->default(0)->after('gross_pay');

            $table->text('selected_deductions')->nullable()->after('late_deduction');
        });
    }

    public function down(): void
    {
        Schema::table('payroll', function (Blueprint $table) {
            $table->dropColumn([
                'paid_date',
                'present_days',
                'absent_days',
                'late_days',
                'late_deduction',
                'selected_deductions',
            ]);

            $table->date('cut_off_start')->nullable(false)->change();
            $table->date('cut_off_end')->nullable(false)->change();
        });
    }
};