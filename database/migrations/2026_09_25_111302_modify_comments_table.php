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
        Schema::table('comments', function (Blueprint $table) {
            // Existing columns ko modify karna
            $table->string('name')->default('Guest')->change();
            $table->string('email')->nullable()->change();

            // Naye columns add karna
            $table->string('ip_address', 45)->nullable()->after('status');
            $table->text('user_agent')->nullable()->after('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Revert changes
            $table->string('name')->default(null)->change();
            $table->string('email')->nullable(false)->change();

            // Drop newly added columns
            $table->dropColumn(['ip_address', 'user_agent']);
        });
    }
};
