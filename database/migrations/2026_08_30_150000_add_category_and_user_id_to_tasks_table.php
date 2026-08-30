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
        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'category')) {
                $table->string('category')->default('Operations')->after('priority');
            }
            if (! Schema::hasColumn('tasks', 'assigned_user_id')) {
                $table->foreignId('assigned_user_id')->nullable()->after('assigned_to')->constrained('users')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['assigned_user_id']);
            $table->dropColumn(['category', 'assigned_user_id']);
        });
    }
};
