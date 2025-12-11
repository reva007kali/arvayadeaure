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
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('package_type')->default('basic');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_status')->default('unpaid');
            $table->string('payment_proof')->nullable();
            $table->timestamp('active_until')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'package_type',
                'amount',
                'payment_status',
                'payment_proof',
                'active_until',
            ]);
        });
    }
};
