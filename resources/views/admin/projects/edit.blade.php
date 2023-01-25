@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <h1>Editing Project: {{ $project->name }}</h1>

        {{-- show an error if the form is not correct --}}
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
            {{-- enctype: image storage --}}
            @csrf
            @method('put')

            {{-- name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $project->name) }}" placeholder="Project name...">
            </div>

            {{-- body --}}
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="3"
                    placeholder="Project body...">{{ old('body', $project->body) }}</textarea>
            </div>

            {{-- cover_image --}}
            <div class="mb-3 d-flex gap-3">
                {{-- actual project image --}}
                @if ($project->cover_img)
                    <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->title }}" class="edit_image">
                @endif

                <div class="w-100">
                    <label for="cover_img" class="form-label">Cover Image</label>
                    <input type="file" name="cover_img" id="cover_img"
                        class="form-control @error('cover_img') is-invalid @enderror" placeholder="Cover image...">
                </div>
            </div>

            {{-- github repository --}}
            <div class="mb-3">
                <label for="github_repo" class="form-label">GitHub Repository</label>
                <input type="text" name="github_repo" id="github_repo"
                    class="form-control @error('github_repo') is-invalid @enderror"
                    value="{{ old('github_repo', $project->github_repo) }}" placeholder="Project link...">
            </div>

            {{-- publication date --}}
            <div class="mb-3">
                <label for="publication_date" class="form-label">Publication Date</label>
                <input type="date" name="publication_date" id="publication_date"
                    class="form-control @error('publication_date') is-invalid @enderror"
                    value="{{ old('publication_date', $project->publication_date) }}" placeholder="Project date...">
            </div>

            {{-- type --}}
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select class="form-select @error('type_id') 'is-invalid' @enderror" name="type_id" id="type_id">
                    <option value="">No type</option>

                    @forelse ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ $type->id == old('type_id', $project->type ? $project->type->id : '') ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @empty
                        <option value="">No types stored</option>
                    @endforelse
                </select>
            </div>

            {{-- technologies --}}
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

            {{-- is important --}}
            <div class="form-check form-switch mb-3">
                <input class="form-check-input @error('is_important') is-invalid @enderror" type="checkbox" role="switch"
                    name="is_important" id="is_important"
                    {{ old('is_important', $project->is_important) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_important">
                    Check as important
                </label>
            </div>

            {{-- submit --}}
            <button type="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
@endsection
