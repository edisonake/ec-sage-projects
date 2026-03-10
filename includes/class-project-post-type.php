<?php
/**
 * Project Post Type Registration
 *
 * @package Project_Manager
 */

namespace ECSageProjects;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Project Post Type Class
 */
class Project_Post_Type {

    /**
     * Instance of this class
     *
     * @var Project_Post_Type
     */
    private static $instance = null;

    /**
     * Get instance
     *
     * @return Project_Post_Type
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
        add_action( 'init', array( $this, 'register_post_type' ), 0 );
        add_action( 'init', array( $this, 'register_taxonomies' ), 0 );
    }

    /**
     * Register Project Custom Post Type
     */
    public function register_post_type(): void {
        $labels = array(
            'name'                  => _x( 'Projects', 'Post Type General Name', 'ec-sage-projects' ),
            'singular_name'         => _x( 'Project Item', 'Post Type Singular Name', 'ec-sage-projects' ),
            'menu_name'             => __( 'Projects', 'ec-sage-projects' ),
            'name_admin_bar'        => __( 'Project Item', 'ec-sage-projects' ),
            'archives'              => __( 'Project Archives', 'ec-sage-projects' ),
            'attributes'            => __( 'Project Attributes', 'ec-sage-projects' ),
            'parent_item_colon'     => __( 'Parent Project Item:', 'ec-sage-projects' ),
            'all_items'             => __( 'All Project Items', 'ec-sage-projects' ),
            'add_new_item'          => __( 'Add New Project Item', 'ec-sage-projects' ),
            'add_new'               => __( 'Add New', 'ec-sage-projects' ),
            'new_item'              => __( 'New Project Item', 'ec-sage-projects' ),
            'edit_item'             => __( 'Edit Project Item', 'ec-sage-projects' ),
            'update_item'           => __( 'Update Project Item', 'ec-sage-projects' ),
            'view_item'             => __( 'View Project Item', 'ec-sage-projects' ),
            'view_items'            => __( 'View Project Items', 'ec-sage-projects' ),
            'search_items'          => __( 'Search Project', 'ec-sage-projects' ),
            'not_found'             => __( 'Not found', 'ec-sage-projects' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'ec-sage-projects' ),
            'featured_image'        => __( 'Featured Image', 'ec-sage-projects' ),
            'set_featured_image'    => __( 'Set featured image', 'ec-sage-projects' ),
            'remove_featured_image' => __( 'Remove featured image', 'ec-sage-projects' ),
            'use_featured_image'    => __( 'Use as featured image', 'ec-sage-projects' ),
            'insert_into_item'      => __( 'Insert into project item', 'ec-sage-projects' ),
            'uploaded_to_this_item' => __( 'Uploaded to this project item', 'ec-sage-projects' ),
            'items_list'            => __( 'Project items list', 'ec-sage-projects' ),
            'items_list_navigation' => __( 'Project items list navigation', 'ec-sage-projects' ),
            'filter_items_list'     => __( 'Filter project items list', 'ec-sage-projects' ),
        );

        $args = array(
            'label'               => __( 'Project Item', 'ec-sage-projects' ),
            'description'         => __( 'Project items for showcasing work', 'ec-sage-projects' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'revisions', 'custom-fields', 'excerpt' ),
            'taxonomies'          => array( 'project_tag' ),
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-portfolio',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => 'projects',
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'show_in_rest'        => true,
            'rewrite'             => array(
                'slug'       => 'projects',
                'with_front' => false,
            ),
        );

        register_post_type( 'project', $args );
    }

    /**
     * Register Project Taxonomies
     */
    public function register_taxonomies(): void {
        // Project Tags
        $tag_labels = array(
            'name'                       => _x( 'Project Tags', 'Taxonomy General Name', 'ec-sage-projects' ),
            'singular_name'              => _x( 'Project Tag', 'Taxonomy Singular Name', 'ec-sage-projects' ),
            'menu_name'                  => __( 'Project Tags', 'ec-sage-projects' ),
            'all_items'                  => __( 'All Tags', 'ec-sage-projects' ),
            'parent_item'                => __( 'Parent Tag', 'ec-sage-projects' ),
            'parent_item_colon'          => __( 'Parent Tag:', 'ec-sage-projects' ),
            'new_item_name'              => __( 'New Tag Name', 'ec-sage-projects' ),
            'add_new_item'               => __( 'Add New Tag', 'ec-sage-projects' ),
            'edit_item'                  => __( 'Edit Tag', 'ec-sage-projects' ),
            'update_item'                => __( 'Update Tag', 'ec-sage-projects' ),
            'view_item'                  => __( 'View Tag', 'ec-sage-projects' ),
            'separate_items_with_commas' => __( 'Separate tags with commas', 'ec-sage-projects' ),
            'add_or_remove_items'        => __( 'Add or remove tags', 'ec-sage-projects' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'ec-sage-projects' ),
            'popular_items'              => __( 'Popular Tags', 'ec-sage-projects' ),
            'search_items'               => __( 'Search Tags', 'ec-sage-projects' ),
            'not_found'                  => __( 'Not Found', 'ec-sage-projects' ),
            'no_terms'                   => __( 'No tags', 'ec-sage-projects' ),
            'items_list'                 => __( 'Tags list', 'ec-sage-projects' ),
            'items_list_navigation'      => __( 'Tags list navigation', 'ec-sage-projects' ),
        );

        $tag_args = array(
            'labels'            => $tag_labels,
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'show_in_rest'      => true,
            'rewrite'           => array(
                'slug' => 'project-tag',
                'with_front' => false,
            ),
        );

        register_taxonomy( 'project_tag', [ 'project' ], $tag_args );
    }
}
