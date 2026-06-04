<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('employees')) {
            Schema::create('employees', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('position', 50);
                $table->decimal('monthly_salary', 10, 2);
                $table->date('hire_date')->nullable();
                $table->enum('status', ['active', 'inactive'])->default('active');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('attendance')) {
            Schema::create('attendance', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->date('date');
                $table->time('time_in')->nullable();
                $table->time('time_out')->nullable();
                $table->enum('status', ['present', 'absent', 'late'])->default('present');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('deductions')) {
            Schema::create('deductions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->enum('type', ['SSS', 'Pag-IBIG', 'PhilHealth', 'Late', 'Absent', 'Other']);
                $table->decimal('amount', 10, 2);
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('payroll')) {
            Schema::create('payroll', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->date('paid_date')->nullable();
                $table->date('cut_off_start')->nullable();
                $table->date('cut_off_end')->nullable();
                $table->unsignedTinyInteger('present_days')->default(0);
                $table->unsignedTinyInteger('absent_days')->default(0);
                $table->unsignedTinyInteger('late_days')->default(0);
                $table->integer('total_days')->default(0);
                $table->decimal('gross_pay', 10, 2)->default(0);
                $table->decimal('late_deduction', 10, 2)->default(0);
                $table->text('selected_deductions')->nullable();
                $table->decimal('total_deductions', 10, 2)->default(0);
                $table->decimal('net_pay', 10, 2)->default(0);
                $table->timestamp('generated_at')->useCurrent();
                $table->timestamp('updated_at')->nullable();
            });
        }
    }
};
