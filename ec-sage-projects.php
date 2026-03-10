<?php
/**
 * Plugin Name: EC Sage Project CPT
 * Plugin URI: https://edisoncalle.com
 * Description: A complete portfolio/project custom post type with custom templates and taxonomies. Includes archive and single project item views.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.0
 * Requires Roots Sage v11
 * Author: Edison Calle
 * Author URI: https://edisoncalle.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace ECSageProjects;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define our constants
if ( ! defined( 'EC_SAGE_PROJECTS_VERSION' ) ) {
    define( 'EC_SAGE_PROJECTS_VERSION', '1.0.0' );
}
if ( ! defined( 'EC_SAGE_PROJECTS_PLUGIN_DIR' ) ) {
    define( 'EC_SAGE_PROJECTS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'EC_SAGE_PROJECTS_PLUGIN_URL' ) ) {
    define( 'EC_SAGE_PROJECTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'EC_SAGE_PROJECTS_PLUGIN_FILE' ) ) {
    define( 'EC_SAGE_PROJECTS_PLUGIN_FILE', __FILE__ );
}

/**
 * Main Projects Class
 */
class EC_Sage_Projects {

    /**
     * Instance of this class
     *
     * @var EC_Sage_Projects
     */
    private static $instance = null;

    /**
     * Get instance
     *
     * @return EC_Sage_Projects
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->init();
    }

    /**
     * Initialize plugin
     */
    private function init(): void {
        // Load dependencies
        require_once EC_SAGE_PROJECTS_PLUGIN_DIR . 'includes/class-project-post-type.php';
        require_once EC_SAGE_PROJECTS_PLUGIN_DIR . 'includes/class-project-templates.php';

        // Initialize components
        Project_Post_Type::get_instance();
        Project_CPT_Templates::get_instance();

        // Register plugin views for Sage
        add_action( 'after_setup_theme', array( $this, 'register_plugin_views' ), 20 );
    }

    /**
     * Register the plugin views path with Sage to recreate the Sage folder structure
     */
    public function register_plugin_views(): void {
        $plugin_views_path = EC_SAGE_PROJECTS_PLUGIN_DIR . 'resources/views';

        if ( ! is_dir( $plugin_views_path ) ) {
            $this->debug_log( 'View path does not exist', $plugin_views_path );
            return;
        }

        if ( ! function_exists( '\Roots\view' ) ) {
            $this->debug_log( 'ERROR: Sage not active - Roots\view function not found' );
            return;
        }

        // Register view path directly with the View Finder
        try {
            $view_factory = \app( 'view' );
            $view_factory->getFinder()->addLocation( $plugin_views_path );
            $this->debug_log( 'Added view path via View Finder', $plugin_views_path );

            if ( file_exists( EC_SAGE_PROJECTS_PLUGIN_DIR . 'includes/View/Composers/Project.php' ) ) {
                require_once EC_SAGE_PROJECTS_PLUGIN_DIR . 'includes/View/Composers/Project.php';
            }

            // Register the Composer
            if ( class_exists( '\ECSageProjects\View\Composers\Project' ) ) {
                $view_factory->composer(
                    [
                        'archive-project',
                        'single-project',
                        'taxonomy-project_tag',
                        'front-page' // to be used by theme front page template
                    ],
                    \ECSageProjects\View\Composers\Project::class
                );
                $this->debug_log( 'Registered Project Composer' );
            }
        } catch ( \Exception $e ) {
            $this->debug_log( 'ERROR registering view paths', $e->getMessage() );
        }
    }

    /**
     * Activation hook
     */
    public function activate(): void {
        // Trigger the post type and taxonomies registration
        if ( class_exists( Project_Post_Type::class ) ) {
            Project_Post_Type::get_instance()->register_post_type();
            Project_Post_Type::get_instance()->register_taxonomies();
        }

        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Deactivation hook
     */
    public function deactivate(): void {
        // Flush rewrite rules
        flush_rewrite_rules();
    }

    /**
     * Debug logging helper
     *
     * @param string $message Log message
     * @param mixed|null $data Additional data to log
     */
    private function debug_log( string $message, mixed $data = null ): void {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            $log_message = "EC Project [Main]: {$message}";
            if ( $data !== null ) {
                $log_message .= ' | ' . ( is_string( $data ) ? $data : print_r( $data, true ) );
            }
            error_log( $log_message );
        }
    }
}

// Initialize the plugin
EC_Sage_Projects::get_instance();

// Register activation/deactivation
register_activation_hook( EC_SAGE_PROJECTS_PLUGIN_FILE, array( EC_Sage_Projects::get_instance(), 'activate' ) );
register_deactivation_hook( EC_SAGE_PROJECTS_PLUGIN_FILE, array( EC_Sage_Projects::get_instance(), 'deactivate' ) );
