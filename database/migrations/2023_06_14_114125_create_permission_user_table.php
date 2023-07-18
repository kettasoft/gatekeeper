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
        Schema::create(config('gatekeeper.tables.permission_user'), function (Blueprint $table) {
            $table->unsignedBigInteger(config('gatekeeper.foreign_keys.permission'));
            $table->morphs('user');
            $table->boolean('status')->default(config('gatekeeper.tables.default_status'));

            $table->foreign(config('gatekeeper.foreign_keys.permission'))->references('id')->on(config('gatekeeper.tables.permissions'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('gatekeeper.tables.permission_user'));
    }
};
