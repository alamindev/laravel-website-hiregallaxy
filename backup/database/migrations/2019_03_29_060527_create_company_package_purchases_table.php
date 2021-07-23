<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPackagePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_package_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_profile_id');
            $table->unsignedInteger('package_id');
            $table->date('package_purchase_date');
            $table->date('package_expiry_date');
            $table->timestamps();


            $table->foreign('company_profile_id')->references('id')->on('company_profiles');
            $table->foreign('package_id')->references('id')->on('packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_package_purchases');
    }
}
