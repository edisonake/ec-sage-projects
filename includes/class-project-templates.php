<?php
/**
 * Project Template Loader
 *
 * @package EC_Sage_Projects
 */

namespace ECSageProjects;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Project_CPT_Templates {

    private static $instance = null;

    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        // Hook into WordPress template hierarchy
        add_filter( 'template_include', array( $this, 'load_project_templates' ), 99 );
    }

    /**
     * Load custom Projects post type templates
     *
     * We return a stable PHP wrapper that renders a Sage Blade view.
     * * Sage will resolve theme overrides first (theme view paths are registered before plugin paths).
     *
     * Hierarchy:
     * 1. Theme override: themes/roots-sage-theme/resources/views/archive-project.blade.php
     * 2. Plugin default: plugins/ec-sage-projects/resources/views/archive-project.blade.php
     */
    public function load_project_templates( $template ) {

        $view_name = null;

        // Check for project archive
        if ( is_post_type_archive( 'project' ) ) {
            $view_name = 'archive-project';
        }

        // Check for single project post
        elseif ( is_singular( 'project' ) ) {
            $view_name = 'single-project';
        }

        // Check for project tags taxonomy
        elseif ( is_tax( 'project_tag' ) ) {
            $view_name = 'taxonomy-project_tag';

            // Check if the taxonomy template exists, otherwise fallback to archive
            if ( ! $this->view_exists( $view_name ) ) {
                $this->debug_log( 'Taxonomy view not found, falling back to archive-project' );
                $view_name = 'archive-project';
            }
        }

        if ( ! $view_name ) {
            return $template;
        }

        if ( ! function_exists( '\Roots\view' ) ) {
            // CPT can exist without Sage, but templates require it.
            $this->debug_log( 'Sage not available; falling back to default WP template' );
            return $template;
        }

        if ( ! $this->view_exists( $view_name ) ) {
            $this->debug_log( 'View not found; falling back to default WP template', $view_name );
            return $template;
        }

        // Pass the view name to the wrapper.
        $GLOBALS['ec_sage_projects_view'] = $view_name;

        $wrapper = EC_SAGE_PROJECTS_PLUGIN_DIR . 'templates/render-blade.php';
        if ( file_exists( $wrapper ) ) {
            return $wrapper;
        }

        $this->debug_log( 'Wrapper template missing', $wrapper );
        return $template;
    }

    /**
     * Check if a view exists in Sage
     *
     * @param string $view_name View name
     *
     * @return bool
     */
    private function view_exists( string $view_name ): bool {
        if ( ! function_exists( '\Roots\view' ) ) {
            return false;
        }

        try {
            $view_factory = app( 'view' );
            return $view_factory->exists( $view_name );
        } catch ( \Throwable $e ) {
            $this->debug_log( 'Error checking if view exists', $e->getMessage() );
            return false;
        }
    }

    /**
     * Debug logging helper
     *
     * @param string $message Log message
     * @param mixed|null $data Additional data to log
     */
    private function debug_log( string $message, mixed $data = null ): void {
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG && defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            $log_message = "EC Project [Templates]: {$message}";
            if ( $data !== null ) {
                $log_message .= ' | ' . ( is_string( $data ) ? $data : print_r( $data, true ) );
            }
            error_log( $log_message );
        }
    }
}
