@php
  $postType = 'project';

  // If used on the project archive, rely on the main query.
  $useMainQuery = is_post_type_archive( $postType ) || is_tax( 'project_tag' );

  if ( ! $useMainQuery ) {
    $paged = get_query_var('paged') ?: 1;

    $projectQuery = new WP_Query([
      'post_type'      => $postType,
      'posts_per_page' => 6,
      'paged'          => $paged,
    ]);
  }
@endphp

@if( $useMainQuery )

  @if( have_posts() )
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto px-4">
      @while( have_posts() ) @php( the_post() )
      @php( $project_tags = $get_project_tags( get_the_ID() ) )
        <x-card :card_tags="$project_tags" />
      @endwhile
    </div>

  @else
    <p>{{ __('No project items found.', 'ec-sage-projects') }}</p>
  @endif

@else
  @if( $projectQuery->have_posts() )
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto px-4">
      @while( $projectQuery->have_posts() ) @php( $projectQuery->the_post() )
      @php( $project_tags = $get_project_tags( get_the_ID() ) )
        <x-card :card_tags="$project_tags" />
      @endwhile
    </div>

    @php(wp_reset_postdata())
  @else
    <p>{{ __('No project items found.', 'ec-sage-projects') }}</p>
  @endif

@endif
