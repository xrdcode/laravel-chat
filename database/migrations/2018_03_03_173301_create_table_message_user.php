<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessageUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("operators", function(Blueprint $table) {
            $table->increments("id");
            $table->string("name");

            $table->timestamps();

        });

        Schema::create("products", function(Blueprint $table) {
            $table->increments("id");
            $table->string("name");

            $table->timestamps();

        });

        Schema::create('chat_messages', function(Blueprint $table) {
           $table->increments("id");
            $table->unsignedInteger("product_id");
            $table->unsignedInteger("operator_id")->nullable();
            $table->unsignedInteger("user_id");
            $table->text("body")->nullable();
            $table->boolean("isFromUser")->default(true);

            $table->timestamps();

            $table->foreign('user_id')->references("id")->on("users")->onDelete('cascade');
            $table->foreign('operator_id')->references("id")->on("operators")->onDelete('cascade');
            $table->foreign('product_id')->references("id")->on("products")->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("chat_messages");
        Schema::dropIfExists("products");
        Schema::dropIfExists("operators");
    }
}
