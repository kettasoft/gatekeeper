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
        Schema::create(Config::get('gatekeeper.tables.permission_role'), function (Blueprint $table) {
            $table->unsignedBigInteger(Config::get('gatekeeper.foreign_keys.permission'));
            $table->unsignedBigInteger(Config::get('gatekeeper.foreign_keys.role'));

            $table->foreign(Config::get('gatekeeper.foreign_keys.role'))->references('id')->on(Config::get('gatekeeper.tables.roles'))->onDelete('cascade');
            $table->foreign(Config::get('gatekeeper.foreign_keys.permission'))->references('id')->on(Config::get('gatekeeper.tables.permissions'))->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Config::get('gatekeeper.tables.permission_role'));
    }
};
