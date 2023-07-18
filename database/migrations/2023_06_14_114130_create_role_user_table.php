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
        Schema::create(config('gatekeeper.tables.role_user'), function (Blueprint $table) {
            $table->unsignedBigInteger(config('gatekeeper.foreign_keys.role'));
            $table->morphs('user');

            $table->foreign(config('gatekeeper.foreign_keys.role'))->references('id')->on(config('gatekeeper.tables.roles'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('gatekeeper.tables.role_user'));
    }
};
