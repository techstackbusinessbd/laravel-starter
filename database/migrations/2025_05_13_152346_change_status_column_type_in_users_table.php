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
        // Step 1: Drop existing 'status' column if it exists
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });

        // Step 2: Add 'status' as tinyInteger
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
        // Step 1: Drop tinyInteger status column
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });

        // Step 2: Re-add 'status' as enum
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])
                ->default('active')
                ->after('email');
        });
    }
};