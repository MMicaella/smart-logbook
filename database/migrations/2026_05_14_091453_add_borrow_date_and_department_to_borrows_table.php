<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {

            $table->timestamp('borrow_date')->nullable();

            $table->string('department')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {

            $table->dropColumn([
                'borrow_date',
                'department'
            ]);

        });
    }
};