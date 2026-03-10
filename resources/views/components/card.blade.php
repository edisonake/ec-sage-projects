<?php
  // Card Component Template.
?>

@props([
    'card_tags' => null,
])

<article {{ $attributes->merge(['class' => 'card shadow-sm card-border border-gray-700 rounded-lg card-base']) }}>
  <figure>
    @if (has_post_thumbnail())
      @php(the_post_thumbnail('medium_large', ['class' => 'w-full h-48 object-cover']))
    @else
      <img src="" alt="{!! get_the_title() !!}" />
    @endif
  </figure>

  <div class="card-body">
    <div class="flex items-start">
      <h2 class="card-title mb-1">
        <a href="{{ get_permalink() }}" class="hover:link !no-underline text-white">
          {!! get_the_title() !!}
        </a>
      </h2>
    </div>

    <p class="text-sm opacity-70 line-clamp-2">
      {!! wp_trim_words(get_the_excerpt(), 20) !!}
    </p>

    <div class="flex flex-wrap gap-1 mb-1">
      @if( $card_tags && is_array( $card_tags ) )
        @foreach( $card_tags as $tag )

          <div class="badge badge-secondary badge-outline uppercase text-[10px] font-bold">
            <a href="{{ $tag['link'] }}" class="hover:link decoration-0 {{ $tag['taxonomy'] . '-' . $tag['slug'] }}">{{ $tag['name'] }}</a>
          </div>

        @endforeach
      @endif
    </div>

    <div class="card-actions justify-end mt-4">
      <a href="{{ get_permalink() }}" class="btn btn-ec btn-sm">
        View Project
      </a>
    </div>
  </div>
</article>
