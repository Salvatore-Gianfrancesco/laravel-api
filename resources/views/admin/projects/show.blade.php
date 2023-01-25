@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        {{-- project name --}}
        <h2>{{ $project->name }}</h2>

        <div class="row row-cols-2">
            @if ($project->cover_img)
                <div class="col">
                    {{-- project image --}}
                    <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->title }}"
                        class="show_image img-fluid my-2">
                </div>
            @endif

            <div class="col">
                <div class="d-flex flex-column gap-3 py-3">
                    {{-- project type --}}
                    <div>
                        <strong>Type</strong>:
                        {{ $project->type ? $project->type->name : 'No type' }}
                    </div>

                    {{-- project technologies --}}
                    <div>
                        <strong>Technologies</strong>:
                        @if (count($project->technologies) > 0)
                            @foreach ($project->technologies as $technology)
                                <span>{{ $technology->name }} </span>
                            @endforeach
                        @else
                            <span>No technologies</span>
                        @endif
                    </div>

                    {{-- project date --}}
                    <div>
                        <strong>Publication Date</strong>:
                        {{ $project->publication_date ? $project->publication_date : 'No date' }}
                    </div>

                    {{-- project link --}}
                    <div>
                        <strong>GitHub Repository</strong>:
                        @if ($project->github_repo)
                            <a href="{{ $project->github_repo }}">{{ $project->github_repo }}</a>
                        @else
                            <span>No link</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- project body --}}
        <p>{{ $project->body }}</p>

        <a href="{{ Route('admin.projects.index') }}" class="btn btn-primary">
            <i class="fa-solid fa-left-long"></i>
            Go Back
        </a>
    </div>
@endsection
