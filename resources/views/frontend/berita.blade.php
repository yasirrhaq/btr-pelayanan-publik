@extends('frontend.layouts.main')
@section('beritaHeader')
	<div>
		<h1 class="title-berita">Berita {{ config('app.name') }} </h1>
		<div class="d-flex justify-content-center">
			<div class="divider-title-berita"></div>
		</div>
	</div>
@endsection
@section('container')
	<div class="col-8 d-flex justify-content-between">
		<div class="col-15 d-flexbox row justify-content-evenly">
			<div class="container overflow-hidden">
				<div class="row g-3">
					@if ($posts->count())
						@foreach ($posts as $post)
							<div class="col-6">
								<div class="card h-100">
									@if ($post->image)
									<div class="ratio ratio-16x9">
										<img src="{{  asset( $post->image) }}" class="card-img-top" alt="...">
									</div>
									@else
									<div class="ratio ratio-16x9">
										<img src="https://source.unsplash.com/random/?{{ $post->category->name }}" class="card-img-top" alt="...">
									</div>
									@endif
									<div class="card-body">
										<h5 class="card-title fw-bold">{{ $post->title }}</h5>
										<p class="card-text">{{ $post->excerpt }}
										</p>
									</div>
									<div class="d-flex justify-content-end btn-show " >

										<a href="{{ url('berita' , [ 'slug' => $post->slug ]) }}" class="button-card-home"> Baca Selengkapnya </a>
									</div>
									<div class="card-footer">
										<small class="text-muted">Last updated {{ $post->updated_at}}</small>
									</div>
								</div>
							</div>
						@endforeach
					@else
						<p class="text-center fs-4">No post found.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endsection
