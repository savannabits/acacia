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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('db_type')->nullable();
            $table->string('html_type')->nullable();
            $table->longText('server_validation')->nullable();
            $table->longText('client_validation')->nullable();
            $table->boolean('is_vue')->default(true);
            $table->boolean('has_options')->default(false);
            $table->boolean('is_guarded')->default(true);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('in_form')->default(true);
            $table->boolean('in_list')->default(false);
            $table->string('options_route_name')->nullable();
            $table->string('options_label_field')->nullable();
            $table->foreignId('schematic_id')
                ->constrained('schematics')
                ->cascadeOnDelete();
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
        Schema::dropIfExists('fields');
    }
};
