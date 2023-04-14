<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_info', function (Blueprint $table) {
            $table->id();

            $table->string('reference');
            $table->string('management_type')->nullable();
            $table->string('description')->nullable();
            $table->string('principal_image')->nullable();
            $table->string('folder');

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
        Schema::dropIfExists('basic_info');
    }
}
