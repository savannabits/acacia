<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection='acacia';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schematics', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('model_class')->nullable();
            $table->string('controller_class')->nullable();
            $table->string('route_name')->nullable();
            $table->string('default_label_column')->nullable();
            $table->timestamp('generated_at')->nullable();
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
        Schema::dropIfExists('schematics');
    }
};
