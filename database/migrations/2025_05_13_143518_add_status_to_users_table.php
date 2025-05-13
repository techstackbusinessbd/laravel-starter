<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the old 'status' column if it exists and recreate it as tinyInteger
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('status')
                ->default(1) // 1 = Active, 0 = Inactive
                ->after('email')
                ->comment('1 = Active, 0 = Inactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tinyInteger and revert back to enum
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])
                ->default('active')
                ->after('email');
        });
    }
};