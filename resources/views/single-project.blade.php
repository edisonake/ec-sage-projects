@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    <article @php(post_class('project-single max-w-5xl mx-auto'))>
      <header class="entry-header mt-12 mb-9">
        <h1 class="entry-title text-4xl font-bold mb-4">
          {!! get_the_title() !!}
        </h1>

        <div class="entry-meta text-gray-600 mb-4">

        </div>
      </header>

      <div class="entry-content prose max-w-none">
        @php(the_content())
      </div>

    </article>

  @endwhile
@endsection
