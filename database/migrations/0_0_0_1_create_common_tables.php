<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommonTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this
            ->commandLogs()
            ->files()
            ->images()
            // ->personalData() // @todo finish
            // ->companyData() // @todo finish
            ->countries()
            ->regions()
            ->districts()
            ->cities()
            ->cadastralAreas()
            ->addresses()
            ->languages()
            ->locales()
            ->localizations()
            ->nationalities()
            ->countryLanguages()
            ->countryLocales()
            ->containerContainee()
            ->attributes()
            ->webs()
            ->webFrontpageSettings()
            ->webLocalizations();
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('webs');
        Schema::dropIfExists('web_frontpage_settings');
        Schema::dropIfExists('web_has_localizations');
        Schema::dropIfExists('files');
        Schema::dropIfExists('images');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('regions');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('cadastral_areas');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('locales');
        Schema::dropIfExists('localizations');
        Schema::dropIfExists('nationalities');
        Schema::dropIfExists('country_has_languages');
        Schema::dropIfExists('country_has_locales');
        Schema::dropIfExists('container_has_containee');
        Schema::dropIfExists('attribute_groups');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('model_has_attributes');
        Schema::dropIfExists('command_logs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function commandLogs()
    {
        Schema::create('command_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('caller')->nullable();
            $table->string('command');
            $table->json('arguments')->nullable();
            $table->json('options')->nullable();
            $table->dateTime('started_at');
            $table->dateTime('finished_at')->nullable();
            $table->enum('state', [ 'running', 'success', 'error' ]);
            $table->json('message')->nullable();
            $table->json('error')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function files()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('model');
            $table->string('model_attribute');
            $table->unsignedInteger('model_attribute_position')->default(0);
            $table->boolean('is_model_primary')->default(0);
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('storage_path');
            $table->string('attachment_filename');
            $table->string('original_filename');
            $table->string('mime_type');
            $table->string('extension');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function images()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('model');
            $table->string('model_attribute');
            $table->unsignedInteger('model_attribute_position')->default(0);
            $table->boolean('is_model_primary')->default(0);
            $table->string('name')->nullable();
            $table->string('alt')->nullable();
            $table->text('description')->nullable();
            $table->string('storage_path');
            $table->string('original_filename');
            $table->string('mime_type')->nullable();
            $table->string('extension');
            $table->text('sizes');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this;
    }

    protected function countries()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('capital')->nullable();
		    $table->string('citizenship')->nullable();
		    $table->string('country_code', 3)->default('');
		    $table->string('currency')->nullable();
		    $table->string('currency_code')->nullable();
		    $table->string('currency_sub_unit')->nullable();
            $table->string('currency_symbol', 3)->nullable();
            $table->smallInteger('currency_iso_4217')->unsigned()->nullable();
            $table->tinyInteger('currency_decimals')->unsigned()->nullable();
            $table->string('currency_decimal_separator', 1)->default('.');
            $table->string('currency_thousand_separator', 1)->default(' ');
		    $table->string('full_name');
		    $table->string('iso_3166_2', 2);
		    $table->string('iso_3166_3', 3);
		    $table->string('name');
		    $table->string('region_code', 3)->nullable();
		    $table->string('sub_region_code', 3)->nullable();
		    $table->boolean('eea')->default(0);
		    $table->string('calling_code', 3)->nullable();
            $table->string('flag', 6)->nullable();
            $table->boolean('is_address_label_use_address')->default(1);
            $table->boolean('is_address_label_use_address_detail')->default(0);
            $table->boolean('is_address_label_use_postal_code')->default(1);
            $table->boolean('is_address_label_use_city')->default(1);
            $table->boolean('is_address_label_use_region')->default(0);
            $table->boolean('is_address_label_use_country')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this->importDump('countries');
    }

    protected function personalData()
    {
        Schema::create('personal_data', function (Blueprint $table) {
            $table->increments('id');

            $table->morphs('model');
            $table->string('model_attribute');
            $table->unsignedInteger('model_attribute_position')->default(0);
            $table->boolean('is_model_primary')->default(0);

            $table->unsignedInteger('language_id');
            $table->unsignedInteger('nationality_id');

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');

            $table->string('email')->nullable();
            $table->string('phone_no')->nullable();

            $table->date('birthdate')->nullable();
            $table->enum('gender', ['m', 'f'])->nullable();
            $table->string('bank_account_no')->nullable();

            $table->string('id_card_no')->nullable();
            $table->string('passport_no')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');

            $table->foreign('nationality_id')
                ->references('id')
                ->on('nationalities')
                ->onDelete('cascade');
        });

        return $this;
    }

    protected function regions()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');

            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this
            ->importDump('sk/regions')
            ->importDump('cz/regions');
    }

    protected function districts()
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('region_id');

            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this
            ->importDump('sk/districts')
            ->importDump('cz/districts');
    }

    protected function cities()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('district_id')->nullable();

            $table->enum('type', ['city', 'territory'])->default('territory');
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('zip')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this
            ->importDump('sk/cities')
            ->importDump('cz/cities');
    }

    protected function cadastralAreas()
    {
        Schema::create('cadastral_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('city_id');

            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this
            ->importDump('sk/cadastral_areas')
            ->importDump('cz/cadastral_areas');
    }

    protected function addresses()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('model');
            $table->string('model_attribute');
            $table->unsignedInteger('model_attribute_position')->default(0);
            $table->boolean('is_model_primary')->default(0);

            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->unsignedInteger('country_id')->nullable();
            $table->string('country_name')->nullable();

            $table->unsignedInteger('region_id')->nullable();
            $table->string('region_name')->nullable();

            $table->unsignedInteger('district_id')->nullable();
            $table->string('district_name')->nullable();

            $table->unsignedInteger('city_id')->nullable();
            $table->string('city_name')->nullable();

            $table->unsignedInteger('cadastral_area_id')->nullable();
            $table->string('cadastral_area_name')->nullable();

            $table->string('street_name')->nullable();
            $table->string('street_no')->nullable();
            $table->string('po_box')->nullable();
            $table->string('zip')->nullable();
            $table->string('apartment_no')->nullable();

            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('cadastral_area_id')
                ->references('id')
                ->on('cadastral_areas')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function languages()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->boolean('is_admin_available')->default(0);
            $table->string('iso_639_1');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this->importDump('languages');
    }

    protected function locales()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('name');
            $table->string('local_name');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this->importDump('locales');
    }

    protected function localizations()
    {
        Schema::create('localizations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('seo_url_slug')->unique()->index();

            $table->unsignedInteger('country_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('locale_id');

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->unique([ 'country_id', 'language_id', 'locale_id' ]);
        });

        return $this;
    }

    protected function nationalities()
    {
        Schema::create('nationalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        return $this->importDump('nationalities');
    }

    protected function countryLanguages()
    {
        Schema::create('country_has_languages', function (Blueprint $table) {
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('language_id');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['country_id', 'language_id']);
        });

        return $this->importDump('country_has_languages');
    }

    protected function countryLocales()
    {
        Schema::create('country_has_locales', function (Blueprint $table) {
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('locale_id');

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('locale_id')
                ->references('id')
                ->on('locales')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['country_id', 'locale_id']);
        });

        return $this->importDump('country_has_locales');
    }

    protected function containerContainee()
    {
        Schema::create('container_has_containee', function (Blueprint $table) {
            $table->increments('id')->unique()->index();
            $table->string('container_type');
            $table->unsignedInteger('container_id');
            $table->string('container_relation');
            $table->string('containee_type');
            $table->unsignedInteger('containee_id');
            $table->unsignedInteger('position');
            $table->unsignedInteger('parent_id')->nullable();
            $table->boolean('is_owned')->default(0);

            $table->index(['container_id', 'container_type', 'container_relation'], 'c2c_crid_crtype_crrelation_index');
            $table->index(['containee_id', 'containee_type', 'container_relation'], 'c2c_ceid_cetype_crrelation_index');
            $table->unique(['container_id', 'container_type', 'container_relation', 'containee_id', 'containee_type'], 'c2c_crid_crtype_crrelation_ceid_cetype_index');

            $table->foreign('parent_id')
                ->references('id')
                ->on('container_has_containee')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function attributes()
    {
        Schema::create('attribute_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_filterable')->default(1);
            $table->string('model_type')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_group_id');
            $table->unsignedInteger('attribute_group_position')->default(0);
            $table->enum('type', ['boolean', 'integer', 'decimal', 'string', 'text', 'enum']);
            $table->boolean('is_multiple')->default(0);
            $table->string('name');
            $table->string('units')->nullable();
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('attribute_group_id')
                ->references('id')
                ->on('attribute_groups')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        Schema::create('attribute_values', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attribute_id')->nullable();
            $table->unsignedInteger('attribute_position')->default(0);
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::create('model_has_attributes', function (Blueprint $table) {
            $table->morphs('model');
            $table->unsignedInteger('attribute_id');
            $table->unsignedInteger('attribute_value_id')->nullable();
            $table->boolean('value_boolean')->nullable();
            $table->integer('value_integer')->nullable();
            $table->decimal('value_decimal', 15, 6)->nullable();
            $table->string('value_string')->nullable();
            $table->text('value_text')->nullable();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('attribute_values')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->primary(['model_type', 'model_id', 'attribute_id']);
        });

        return $this;
    }

    protected function webs()
    {
        Schema::create('webs', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('is_enabled')->default(1);

            $table->string('name');
            $table->string('title');
            $table->string('url')->unique();
            $table->string('domain')->unique();
            $table->string('email');
            $table->text('description')->nullable();

            $table->string('color')->nullable();
            $table->boolean('is_label_with_name')->default(1);
            $table->boolean('is_label_with_color')->default(1);
            $table->boolean('is_label_with_flag')->default(0);

            $table->unsignedInteger('user_group_id');
            $table->unsignedInteger('default_localization_id');
            $table->boolean('is_use_default_localization_url_path')->default(0);

            $table->text('error_not_found_message')->nullable();
            $table->text('error_exception_message')->nullable();
            $table->boolean('is_error_exception_debug_mode')->default(1);

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('user_group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('default_localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });

        //DB::statement("INSERT INTO `webs` VALUES (1,'-name-','-title-','https://---/','-domain-','-email-');");

        return $this;
    }

    protected function webFrontpageSettings()
    {
        Schema::create('web_frontpage_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('web_id');

            $table->string('name');
            $table->string('theme')->nullable();
            $table->text('css')->nullable();
            $table->text('js')->nullable();
            $table->text('schema')->nullable();

            $table->string('facebook_page_url')->nullable();
            $table->string('facebook_app_id')->nullable();

            $table->string('youtube_page_url')->nullable();

            $table->string('google_analytics_tracking_code')->nullable();
            $table->string('google_measurement_id')->nullable();
            $table->string('google_tag_manager_container_id')->nullable();

            $table->string('livechatoo_account')->nullable();
            $table->string('livechatoo_language')->nullable();
            $table->string('livechatoo_side')->nullable()->default('right');

            $table->string('dognet_account_id')->nullable();
            $table->string('dognet_campaign_id')->nullable();

            $table->string('twitter_card')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        return $this;
    }

    protected function webLocalizations()
    {
        Schema::create('web_has_localizations', function (Blueprint $table) {
            $table->unsignedInteger('web_id');
            $table->unsignedInteger('localization_id');

            $table->foreign('web_id')
                ->references('id')
                ->on('webs')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('localization_id')
                ->references('id')
                ->on('localizations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['web_id', 'localization_id']);
        });

        return $this;
    }

    private function importDump($table)
    {
        $file = sprintf('%s/%s.sql', \Softworx\RocXolid\Common\ServiceProvider::dumpsPublishPath(), $table);

        try {
            DB::unprepared(file_get_contents($file));
        } catch (\ErrorException $e) {
            dd(__METHOD__, $file, $e);
        }

        return $this;
    }
}