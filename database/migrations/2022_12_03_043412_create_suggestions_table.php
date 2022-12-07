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
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->foreignId('user_id')->constrained();

            $table->float('nhiet_do_bom_min')->nullable();
            $table->float('nhiet_do_bom_max')->nullable();
            $table->float('do_am_khong_khi_bom_min')->nullable();
            $table->float('do_am_khong_khi_bom_max')->nullable();
            $table->float('do_am_dat_bom_min')->nullable();
            $table->float('do_am_dat_bom_max')->nullable();

            $table->float('nhiet_do_den_min')->nullable();
            $table->float('nhiet_do_den_max')->nullable();
            $table->float('do_am_khong_khi_den_min')->nullable();
            $table->float('do_am_khong_khi_den_max')->nullable();
            $table->float('do_am_dat_den_min')->nullable();
            $table->float('do_am_dat_den_max')->nullable();

            $table->text('image')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suggestions');
    }
};
