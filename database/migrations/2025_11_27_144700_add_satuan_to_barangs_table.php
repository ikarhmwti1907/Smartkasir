<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->string('satuan')->default('pcs'); // pcs, lusin, rol, dll
        $table->decimal('harga_satuan', 15, 2)->default(0); // harga per satuan
    });
}

public function down()
{
    Schema::table('barangs', function (Blueprint $table) {
        $table->dropColumn(['satuan', 'harga_satuan']);
    });
}

};