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
        Schema::create('skema_pphs', function (Blueprint $table) {
            $table->id();
						$table->decimal('from',30,2)->nullable();
						$table->decimal('to',30,2)->nullable();
						$table->string('tier',10)->nullable();
						$table->decimal('percentage',30,2)->nullable();
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
        Schema::dropIfExists('skema_pphs');
    }
};
