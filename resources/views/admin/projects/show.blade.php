@extends('layouts.admin')

@section('content')
    <div class="container my-4 d-flex gap-4">
        @if ($project->cover_img)
            <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->title }}" class="show_image img-fluid">
        @endif

        <div>
            <h2>{{ $project->name }}</h2>
            <p>{{ $project->body }}</p>
            <div><strong>Type</strong>: {{ $project->type ? $project->type->name : 'No type' }}</div>
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
        </div>
    </div>

    <a href="{{ Route('admin.projects.index') }}" class="btn btn-primary"><i class="fa-solid fa-left-long"></i> Go Back</a>
    </div>
@endsection
