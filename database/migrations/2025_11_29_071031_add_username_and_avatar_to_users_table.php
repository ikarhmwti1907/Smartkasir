<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $existing = Schema::getColumnListing('users');

            if (!in_array('username', $existing)) {
                $table->string('username')->unique()->after('name');
            }

            if (!in_array('avatar', $existing)) {
                $table->string('avatar')->nullable()->after('email');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $existing = Schema::getColumnListing('users');

            if (in_array('username', $existing)) {
                $table->dropColumn('username');
            }

            if (in_array('avatar', $existing)) {
                $table->dropColumn('avatar');
            }
        });
    }
};