<?php namespace Alexwenzel\RedirectWizard\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAlexwenzelRedirectwizardRedirects extends Migration
{
    public function up()
    {
        Schema::create('alexwenzel_redirectwizard_redirects', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();

            $table->text('redirect_from');
            $table->string('redirect_from_method', 4);
            $table->text('redirect_to');
            $table->string('redirect_to_httpstatus', 3);

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('alexwenzel_redirectwizard_redirects');
    }
}
