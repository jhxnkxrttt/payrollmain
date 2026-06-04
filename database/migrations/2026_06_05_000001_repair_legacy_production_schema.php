<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cache')) {
            Schema::create('cache', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->mediumText('value');
                $table->integer('expiration')->index();
            });
        }

        if (!Schema::hasTable('cache_locks')) {
            Schema::create('cache_locks', function (Blueprint $table) {
                $table->string('key')->primary();
                $table->string('owner');
                $table->integer('expiration')->index();
            });
        }

        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        $this->repairUsers();
        $this->repairEmployees();
        $this->repairAttendance();
        $this->repairDeductions();
        $this->repairPayroll();
    }

    private function repairUsers(): void
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

            if (!Schema::hasColumn('users', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    private function repairEmployees(): void
    {
        if (!Schema::hasTable('employees')) {
            return;
        }

        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'hire_date')) {
                $table->date('hire_date')->nullable();
            }

            if (!Schema::hasColumn('employees', 'status')) {
                $table->enum('status', ['active', 'inactive'])->default('active');
            }

            if (!Schema::hasColumn('employees', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (!Schema::hasColumn('employees', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    private function repairAttendance(): void
    {
        if (!Schema::hasTable('attendance')) {
            return;
        }

        Schema::table('attendance', function (Blueprint $table) {
            if (!Schema::hasColumn('attendance', 'status')) {
                $table->enum('status', ['present', 'absent', 'late'])->default('present');
            }

            if (!Schema::hasColumn('attendance', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (!Schema::hasColumn('attendance', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    private function repairDeductions(): void
    {
        if (!Schema::hasTable('deductions')) {
            return;
        }

        Schema::table('deductions', function (Blueprint $table) {
            if (!Schema::hasColumn('deductions', 'created_at')) {
                $table->timestamp('created_at')->nullable();
            }

            if (!Schema::hasColumn('deductions', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    private function repairPayroll(): void
    {
        if (!Schema::hasTable('payroll')) {
            return;
        }

        Schema::table('payroll', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll', 'paid_date')) {
                $table->date('paid_date')->nullable();
            }

            if (!Schema::hasColumn('payroll', 'cut_off_start')) {
                $table->date('cut_off_start')->nullable();
            }

            if (!Schema::hasColumn('payroll', 'cut_off_end')) {
                $table->date('cut_off_end')->nullable();
            }

            if (!Schema::hasColumn('payroll', 'present_days')) {
                $table->unsignedTinyInteger('present_days')->default(0);
            }

            if (!Schema::hasColumn('payroll', 'absent_days')) {
                $table->unsignedTinyInteger('absent_days')->default(0);
            }

            if (!Schema::hasColumn('payroll', 'late_days')) {
                $table->unsignedTinyInteger('late_days')->default(0);
            }

            if (!Schema::hasColumn('payroll', 'total_days')) {
                $table->integer('total_days')->default(0);
            }

            if (!Schema::hasColumn('payroll', 'gross_pay')) {
                $table->decimal('gross_pay', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('payroll', 'late_deduction')) {
                $table->decimal('late_deduction', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('payroll', 'selected_deductions')) {
                $table->text('selected_deductions')->nullable();
            }

            if (!Schema::hasColumn('payroll', 'total_deductions')) {
                $table->decimal('total_deductions', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('payroll', 'net_pay')) {
                $table->decimal('net_pay', 10, 2)->default(0);
            }

            if (!Schema::hasColumn('payroll', 'generated_at')) {
                $table->timestamp('generated_at')->nullable();
            }

            if (!Schema::hasColumn('payroll', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }
};
