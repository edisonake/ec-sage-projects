<?php

namespace ECSageProjects\View\Composers;

use Roots\Acorn\View\Composer;

class Project extends Composer {

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'archive-project',
        'single-project',
        'taxonomy-project_tag',
        'partials.content-project-loop',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        return [
            'get_project_tags' => function ( int $post_id ): array {
                return $this->get_project_tags( $post_id );
            }
        ];
    }

    /**
     * Returns an array with a list of the project tags terms.
     *
     * @param int $post_id
     *
     * @return array
     */
    public function get_project_tags( int $post_id  ): array {

        $project_tax = 'project_tag';
        $terms       = get_the_terms( $post_id, $project_tax );

        if ( ! is_array( $terms ) ) {
            return [];
        }

        // Collect only what we need
        $tag_list = [];
        foreach ( $terms as $term ) {

            $term_link = get_term_link( $term );
            if ( is_wp_error( $term_link ) ) {
                $term_link = '';
            }

            $single_tag = [];
            $single_tag['name']     = $term->name;
            $single_tag['slug']     = $term->slug;
            $single_tag['link']     = $term_link;
            $single_tag['taxonomy'] = $term->taxonomy;

            $tag_list[] = $single_tag;
        }
        return $tag_list;
    }
}
