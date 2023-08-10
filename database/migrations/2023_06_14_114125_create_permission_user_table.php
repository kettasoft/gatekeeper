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
        Schema::create(Config::get('gatekeeper.tables.permission_user'), function (Blueprint $table) {
            $table->unsignedBigInteger(Config::get('gatekeeper.foreign_keys.permission'));
            $table->morphs('user');
            $table->boolean('status')->default(Config::get('gatekeeper.tables.default_status'));

            $table->foreign(Config::get('gatekeeper.foreign_keys.permission'))->references('id')->on(Config::get('gatekeeper.tables.permissions'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Config::get('gatekeeper.tables.permission_user'));
    }
};
