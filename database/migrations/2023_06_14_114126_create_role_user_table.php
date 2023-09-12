<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Config::get('gatekeeper.tables.role_user'), function (Blueprint $table) {
            $table->unsignedBigInteger(Config::get('gatekeeper.foreign_keys.role'));
            $table->morphs('clientable');
            $table->boolean('status')->default(Config::get('gatekeeper.tables.default_status'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Config::get('gatekeeper.tables.permissions'));
    }
};
