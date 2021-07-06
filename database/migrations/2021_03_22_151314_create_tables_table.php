<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->integer("week_number");
            $table->string('pdf_src');
            $table->date('date_from');
            $table->date('date_to');
            $table->softDeletes($column = 'deleted_at', $precision = 0);

            // Example 1
            // $table->foreignId('course_id')->constrained('course');
            // Example 2
            $table->unsignedBigInteger('program_id');
            $table->foreign('program_id')
                ->references('id')
                ->on('programs')
                ->onDelete('cascade');

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
        Schema::dropIfExists('tables');
    }
}