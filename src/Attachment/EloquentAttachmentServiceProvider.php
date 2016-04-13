<?php
namespace Tysdever\EloquentAttachment;

use File;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class EloquentAttachmentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->defineResources();
        }

        $this->bindFormComponents();

       
        $this->loadTranslationsFrom(__DIR__.'/../resource/lang/', 'attachment');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadService();

        $this->loadResources();

        $this->registerCommands();
        $this->commands('eloquent-attachment.clear');
    }

    /**
     * Load config used by component.
     *
     * @return void
     */
    protected function loadResources()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/eloquent-attachment.php', 'eloquent-attachment'
        );

        

        if (File::exists(resource_path('views/vendor/eloquent-attachment'))) {
            $this->loadViewsFrom(resource_path('views/vendor/eloquent-attachment'), 'eloquent.attachment');
        } else {
            $this->loadViewsFrom(__DIR__ . '/../resource/views/', 'eloquent.attachment');
        }
    }

    public function loadService()
    {
        $this->app->bind('eloquent-attachment', function ($app) {
            return new EloquentAttachment();
        });

        $this->app->bind('attachment-factory', function ($app) {
            return new AttachmentFactory(
                $app['\Tysdever\EloquentAttachment\MimeResolver'],
                $app['\Tysdever\EloquentAttachment\EloquentAttachment']
            );
        });

        AliasLoader::getInstance()->alias('EloquentAttachment', \Tysdever\EloquentAttachment\Facades\EloquentAttachment::class);
        AliasLoader::getInstance()->alias('AttachmentFactory', \Tysdever\EloquentAttachment\Facades\AttachmentFactory::class);
    }

    /**
     * Publish config file.
     *
     * @return void
     */
    protected function defineResources()
    {
        $this->publishes([
            __DIR__ . '/../config/' => config_path(),
            __DIR__ . '/../resource/views'       => resource_path('views/vendor/eloquent-attachment'),
            __DIR__ . '/../resource/assets'       => resource_path('assets/vendor/eloquent-attachment'),
        ]);
    }

    /**
     * Register commands with the container.
     */
    protected function registerCommands()
    {
        $this->app->bind('eloquent-attachment.clear', function ($app) {
            return new Commands\ClearTmpFiles;
        });
    }


    /**
     * Add view components
     * 
     * @return void
     */
    protected function bindFormComponents()
    {

        $form = $this->app->make('form');

        $form::component('bsImageAttachment', 'eloquent.attachment::components.form.image', ['name']);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Collective\Html\HtmlServiceProvider::class
        ];
    }

}
