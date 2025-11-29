<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->foreignId('leave_id')
                ->nullable()
                ->after('karyawan_id')
                ->constrained('leave_requests')
                ->onDelete('set null');

            $table->dropColumn('status');
            $table->enum('status', ['present', 'alpha', 'leave'])
                ->default('present');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropForeign(['leave_id']);
            $table->dropColumn('leave_id');

            $table->dropColumn('status');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha'])
                ->default('hadir');
        });
    }
};
