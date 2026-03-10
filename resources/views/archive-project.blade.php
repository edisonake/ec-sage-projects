@extends('layouts.app')

@section('content')

  <header class="page-header mb-8">

    <h1 class="page-title text-4xl font-bold">
      @if( is_tax( 'project_tag' ) )
        {{ single_term_title() }}
      @else
        {{ __('Projects', 'ec-sage-projects') }}
      @endif
    </h1>
  </header>

  @include( 'partials.content-project-loop' )

  <div class="mt-10">
    <?php the_posts_pagination(['class' => 'join']);?>
  </div>

@endsection
