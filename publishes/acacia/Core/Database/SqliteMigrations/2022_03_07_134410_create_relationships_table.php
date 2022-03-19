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
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('method');
            $table->foreignId('schematic_id')->constrained('schematics')->cascadeOnDelete();
            $table->foreignId('related_id')->nullable()->constrained('schematics')->restrictOnDelete();
            $table->string('related_key')->nullable()->default('id');
            $table->string('related_table')->nullable();
            $table->string('local_key')->nullable();
            $table->string('label_column')->nullable();
            $table->boolean('is_recursive')->default(false);
            $table->boolean('is_morph')->default(false);
            $table->string('morph_type_column')->nullable();
            $table->string('morph_id_column')->nullable();

            $table->longText('server_validation')->nullable();
            $table->boolean('in_list')->default(false);
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
        Schema::dropIfExists('relationships');
    }
};
