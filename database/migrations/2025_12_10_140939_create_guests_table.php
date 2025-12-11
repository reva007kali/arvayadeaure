<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('slug');
            $table->string('category')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('rsvp_status')->default(0);
            $table->integer('pax')->default(1);
            $table->text('message_from_guest')->nullable();
            $table->timestamps();
            $table->unique(['invitation_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
