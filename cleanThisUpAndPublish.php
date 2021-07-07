<?php namespace Cpap\ApiRoutesModule;

use Anomaly\PagesModule\Page\PageModel;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Illuminate\Routing\Router;

class ApiRoutesModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Additional addon plugins.
     *
     * @type array|null
     */
    protected $plugins = [];

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [];

    /**
     * The addon's scheduled commands.
     *
     * @type array|null
     */
    protected $schedules = [];

    /**
     * The addon API routes.
     *
     * @type array|null
     */
    protected $api = [];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [];

    /**
     * The addon middleware.
     *
     * @type array|null
     */
    protected $middleware = [
        //Cpap\ApiRoutesModule\Http\Middleware\ExampleMiddleware::class
    ];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    protected $groupMiddleware = [
        //'web' => [
        //    Cpap\ApiRoutesModule\Http\Middleware\ExampleMiddleware::class,
        //],
    ];

    /**
     * Addon route middleware.
     *
     * @type array|null
     */
    protected $routeMiddleware = [];

    /**
     * The addon event listeners.
     *
     * @type array|null
     */
    protected $listeners = [
        //Cpap\ApiRoutesModule\Event\ExampleEvent::class => [
        //    Cpap\ApiRoutesModule\Listener\ExampleListener::class,
        //],
    ];

    /**
     * The addon alias bindings.
     *
     * @type array|null
     */
    protected $aliases = [
        //'Example' => Cpap\ApiRoutesModule\Example::class
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [];

    /**
     * Additional service providers.
     *
     * @type array|null
     */
    protected $providers = [
        //\ExamplePackage\Provider\ExampleProvider::class
    ];

    /**
     * The addon view overrides.
     *
     * @type array|null
     */
    protected $overrides = [
        //'streams::errors/404' => 'module::errors/404',
        //'streams::errors/500' => 'module::errors/500',
    ];

    /**
     * The addon mobile-only view overrides.
     *
     * @type array|null
     */
    protected $mobile = [
        //'streams::errors/404' => 'module::mobile/errors/404',
        //'streams::errors/500' => 'module::mobile/errors/500',
    ];

   /**
    * Register the addon.
    *
    * @param PageModel $pages
    */
   public function register(PageModel $pages)
   {
       $pages->bind(
           'to_array_for_api',
           function () {
                /**
                 * Black list of content keys we don't want to send back to API
                 */
                $mainKeyBlacklist = [
                    'id' => 0, 
                    'sort_order' => 0, 
                    'created_at' => 0, 
                    'created_by_id' => 0, 
                    'updated_at' => 0, 
                    'updated_by_id' => 0, 
                    'deleted_at' => 0, 
                    'str_id' => 0, 
                    'slug' => 0, 
                    'path' => 0, 
                    'type_id' => 0, 
                    'entry_id' => 0, 
                    'entry_type' => 0, 
                    'parent_id' => 0, 
                    'visible' => 0, 
                    'enabled' => 0, 
                    'exact' => 0, 
                    'home' => 0, 
                    'theme_layout' => 0, 
                    'title' => 0,
                ];
                
                /**
                 * Pyro name space blacklist
                 */
                $namespaceBlacklist = [
                    'anomaly.extension.',
                ];

               /**
                * Get the page as an
                * array to start.
                *
                * This is default behavior.
                */
               $data = $this->toArray();
               
               // Remove extra information we don't need
               $data = array_diff_key($data, $mainKeyBlacklist);

               /**
                * We'll put all our block
                * stuff here in structure.
                */
               $data['structure'] = [];

               /**
                * No blocks! Return what we've got.
                *
                * $this = Page
                * Entry = custom page fields per type
                * Structure = your blocks FT
                */
               if (!$this->entry->page_structure) {
                   return $data;
               }

               /**
                * Recursive (if needed) array cleanup to get rid of all the key's in the current data we don't care for
                */
               $arrayCleaner = function($currArr) use (&$arrayCleaner, $mainKeyBlacklist) {
                   // Multi dimensional?
                   $retArr = [];
                   if(isset($currArr[0]) && is_array($currArr[0])) {
                        // Multidimensional - let's iterate and clean each individually (recursively done, in case of weird situations)
                        foreach($currArr as $arr) {
                            $retArr[] = $arrayCleaner($arr);
                        }
                        return $retArr;
                   }
                   else {
                       // Final level - clean this off and send back
                       return array_diff_key($currArr, $mainKeyBlacklist);
                   }
               };

               /**
                * Main recursive parser to iterate blocks and determine when we have reached our end point
                */
               $blockParser = function($currEntry) use (&$blockParser, $arrayCleaner, $mainKeyBlacklist, $namespaceBlacklist) {             
                    // If this is an object, there may be some nested parsing to do or just conversion to array format      
                    if(gettype($currEntry) == 'object') {
                        // If this is multidimensional and it is an object - we know recursion needs to occur
                        if(isset($currEntry[0]) && gettype($currEntry[0]->extension) == 'object') {
                            // We will set the key to be the current item's id and will recursively parse out rest of the data
                            return [
                                str_replace($namespaceBlacklist, '', $currEntry[0]->extension->id) => $blockParser($currEntry[0]->entry)
                            ];
                        }
                        else {
                            // This is a final data point - change to array format and clean up
                            $passArr = [];
                            $parseArr = $currEntry->toArray();
                            return $arrayCleaner($parseArr);
                        }
                    }
                    else {
                        // We reached a plain value - assign it
                        return $currEntry;
                    }
               };

               /**
                * Foreach block in structure
                * let's get it's custom data
                * (uses type pattern so has an
                * entry model that holds custom
                * fields) and append to our $data.
                *
                * @var BlockModel $block
                */
               foreach ($this->entry->page_structure as $block) {
                    // Pull namespace
                    $namespace = str_replace($namespaceBlacklist, '', $block->extension->getNamespace());

                    // Initialize returned block data
                    $blockData = [];

                    // Iterate current structure and parse out (if needed)
                    foreach($block->entry->fields as $fld) {
                        // Pull object / value
                        $currEntry = $block->entry->$fld;

                        // Recursively build out array
                        $blockData[$fld] = $blockParser($currEntry);
                    }

                    /**
                    * This is our generic output prep.
                    */
                    $data['structure'][] = [
                        'type' => $namespace, // Same for custom CP blocks - they have a virtual addon (see your DB).
                        'data' => $blockData,
                    ];

                    if ($namespace == 'your.custom.type') {
                        // Maybe do something a little different to decorate $data more.
                        // This is only done as needed.
                    }
                }

                return $data;
           }
       );
   }

    /**
     * Boot the addon.
     */
    public function boot()
    {
        // Run extra post-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Map additional addon routes.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Register dynamic routes here for example.
        // Use method injection or commands to bring in services.
    }

}
