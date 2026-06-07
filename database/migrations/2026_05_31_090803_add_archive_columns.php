<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('borrows', 'is_archived')) {
            Schema::table('borrows', function (Blueprint $table) {
                $table->boolean('is_archived')->default(false);
            });
        }

        if (!Schema::hasColumn('bookings', 'is_archived')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->boolean('is_archived')->default(false);
            });
        }

        if (!Schema::hasColumn('request_items', 'is_archived')) {
            Schema::table('request_items', function (Blueprint $table) {
                $table->boolean('is_archived')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('borrows', 'is_archived')) {
            Schema::table('borrows', function (Blueprint $table) {
                $table->dropColumn('is_archived');
            });
        }

        if (Schema::hasColumn('bookings', 'is_archived')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('is_archived');
            });
        }

        if (Schema::hasColumn('request_items', 'is_archived')) {
            Schema::table('request_items', function (Blueprint $table) {
                $table->dropColumn('is_archived');
            });
        }
    }
};