<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
                    public function up(): void
                    {
                                        Schema::table('invitations', function (Blueprint $table) {
                                                            $table->string('payment_action')->nullable()->after('payment_status'); // upgraded, downgraded, refund, cancel
                                                            $table->unsignedBigInteger('due_amount')->default(0)->after('amount'); // amount user needs to pay (for upgrade)
                                                            $table->unsignedBigInteger('refund_amount')->default(0)->after('due_amount'); // suggested refund (for downgrade)
                                        });
                    }

                    public function down(): void
                    {
                                        Schema::table('invitations', function (Blueprint $table) {
                                                            $table->dropColumn(['payment_action', 'due_amount', 'refund_amount']);
                                        });
                    }
};
