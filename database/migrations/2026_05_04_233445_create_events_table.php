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
    Schema::create('events', function (Blueprint $table) {
        $table->id();

        $table->string('title');
        $table->string('slug')->unique();

        $table->text('description');

        $table->string('category');

        $table->enum('event_type', ['online', 'offline', 'hybrid']);

        $table->dateTime('event_date');

        $table->string('location');

        $table->enum('price_type', ['gratis', 'berbayar'])
              ->default('gratis');

        $table->string('price')->nullable();

        $table->string('target_participants');

        $table->text('registration_link');

        $table->string('organizer_name');

        $table->string('contact_person');

        $table->string('poster')->nullable();

        $table->boolean('is_tak')->default(false);

        $table->enum('status', ['pending', 'approved', 'rejected'])
              ->default('pending');

        $table->string('submitted_by');

        $table->string('submitted_email');

        $table->foreignId('approved_by')
              ->nullable()
              ->constrained('users')
              ->nullOnDelete();

        $table->timestamp('approved_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
