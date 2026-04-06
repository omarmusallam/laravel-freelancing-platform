<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name');
            $table->string('site_tagline')->nullable();
            $table->string('contact_email');
            $table->string('support_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_address', 500)->nullable();
            $table->string('meta_title');
            $table->string('meta_description', 500);
            $table->string('meta_keywords', 500)->nullable();
            $table->string('copyright_text')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('footer_logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->string('og_image_path')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}
