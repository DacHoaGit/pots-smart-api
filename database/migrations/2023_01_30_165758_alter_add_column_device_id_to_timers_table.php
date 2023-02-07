<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('timers', 'device_id')) {
            Schema::table('timers', function (Blueprint $table) {
                $table->foreign('device_id')
                    ->references('id')
                    ->on('devices')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        if (Schema::hasColumn('timers', 'device_id')) {
            Schema::table('timers', function (Blueprint $table) {
                $table->dropColumn('device_id');
            });
        }
    }
};
