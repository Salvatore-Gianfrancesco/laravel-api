@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <h1>Create new Project</h1>

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

        <form action="{{ Route('admin.projects.store') }}" method="post" enctype="multipart/form-data"> {{-- enctype: image storage --}}
            @csrf

            {{-- name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="Project name...">
            </div>

            {{-- body --}}
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" rows="3"
                    placeholder="Project body...">{{ old('body') }}</textarea>
            </div>

            {{-- cover_image --}}
            <div class="mb-3">
                <label for="cover_img" class="form-label">Cover Image</label>
                <input type="file" name="cover_img" id="cover_img"
                    class="form-control @error('cover_img') is-invalid @enderror" placeholder="Cover image...">
            </div>

            {{-- type --}}
            <div class="mb-3">
                <label for="type_id" class="form-label">Type</label>
                <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
                    <option value="null">No type</option>

                    @foreach ($types as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- technologies --}}
            <div class="mb-3">
                <label for="technologies" class="form-label">Technologies</label>
                <select multiple class="form-select" name="technologies[]" id="technologies">
                    <option value="null" disabled>Select a technology</option>

                    @forelse ($technologies as $technology)
                        <option value="{{ $technology->id }}"
                            {{ in_array($technology->id, old('technologies', [])) ? 'selected' : '' }}>
                            {{ $technology->name }}</option>
                    @empty
                        <option value="null" disabled>No technologies</option>
                    @endforelse
                </select>
            </div>

            {{-- submit --}}
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
