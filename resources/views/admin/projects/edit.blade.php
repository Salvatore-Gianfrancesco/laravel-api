@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <h1>Editing Project: {{ $project->name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ Route('admin.projects.update', $project->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $project->name) }}" placeholder="Project name...">
            </div>

            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="3"
                    placeholder="Project body...">{{ old('body', $project->body) }}</textarea>
            </div>

            <div class="mb-3 d-flex gap-3">
                @if ($project->cover_img)
                    <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->title }}" width="150px">
                @endif

                <div class="w-100">
                    <label for="cover_img" class="form-label">Cover Image</label>
                    <input type="file" name="cover_img" id="cover_img"
                        class="form-control @error('cover_img') is-invalid @enderror" placeholder="Cover image...">
                </div>
            </div>

            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select class="form-select @error('type_id') 'is-invalid' @enderror" name="type_id" id="type_id">
                    <option value="null">No type</option>

                    @forelse ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ $type->id == old('type_id', $project->type ? $project->type->id : '') ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @empty
                        <option value="null">No types stored</option>
                    @endforelse
                </select>
            </div>

            <div class="mb-3">
                <label for="technologies" class="form-label">Technologies</label>
                <select multiple class="form-select" name="technologies[]" id="technologies">
                    <option value="null" disabled>Select a technology</option>

                    @forelse ($technologies as $technology)
                        @if ($errors->any())
                            <option value="{{ $technology->id }}"
                                {{ in_array($technology->id, old('technologies', [])) ? 'selected' : '' }}>
                                {{ $technology->name }}</option>
                        @else
                            <option value="{{ $technology->id }}"
                                {{ $project->technologies->contains($technology->id) ? 'selected' : '' }}>
                                {{ $technology->name }}</option>
                        @endif
                    @empty
                        <option value="null" disabled>No technologies</option>
                    @endforelse
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
