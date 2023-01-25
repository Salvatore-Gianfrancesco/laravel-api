@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-start">
            <h1>Technologies</h1>

            {{-- form for creating a new technology --}}
            {{-- create - modal button --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalId-create">
                <i class="fa-solid fa-plus"></i>
            </button>

            {{-- create - modal body --}}
            <div class="modal fade" id="modalId-create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
                role="dialog" aria-labelledby="modalTitleId-create" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        {{-- modal header --}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitleId-create">Add a new technology</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        {{-- modal body --}}
                        <div class="modal-body">
                            <form action="{{ Route('admin.technologies.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="d-flex flex-column gap-2">
                                    <div class="d-flex flex-column gap-2">
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" placeholder="Technology name...">
                                        <input type="file" name="icon" id="icon"
                                            class="form-control @error('icon') is-invalid @enderror">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- show an error if the form create is not correct --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- show an alert if there is a message in the session --}}
        @if (session('message'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>{{ session('message') }}</strong>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($technologies as $technology)
                        {{-- show an error if the form update is not correct --}}
                        @error("name-$technology->id", "update-$technology->id")
                            <div class="alert alert-danger w-100">{{ $message }}</div>
                        @enderror
                        @error("icon-$technology->id", "update-$technology->id")
                            <div class="alert alert-danger w-100">{{ $message }}</div>
                        @enderror

                        <tr>
                            {{-- technology id --}}
                            <td scope="row">{{ $technology->id }}</td>

                            {{-- technology icon --}}
                            <td>
                                @if ($technology->icon)
                                    <img src="{{ asset('storage/' . $technology->icon) }}" alt="{{ $technology->name }}"
                                        width="50">
                                @else
                                    <img src="https://via.placeholder.com/300x300.png?text={{ $technology->name }}"
                                        alt="{{ $technology->name }}" width="50">
                                @endif
                            </td>

                            {{-- technology name --}}
                            <td>{{ $technology->name }}</td>

                            {{-- edit and delete buttons --}}
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- edit - modal button --}}
                                    <div>
                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#modalId-update-{{ $technology->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                            Edit
                                        </button>
                                    </div>

                                    {{-- edit - modal body --}}
                                    <div class="modal fade" id="modalId-update-{{ $technology->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-update-{{ $technology->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                {{-- modal header --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId-update-{{ $technology->id }}">
                                                        Editing technology - {{ $technology->id }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                {{-- modal body --}}
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ Route('admin.technologies.update', $technology->id) }}"
                                                        method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('put')

                                                        <div class="d-flex flex-column gap-2">
                                                            <div class="d-flex flex-column gap-2">
                                                                <input type="text" name="name-{{ $technology->id }}"
                                                                    id="name"
                                                                    class="form-control @error("name-$technology->id", "update-$technology->id") is-invalid @enderror"
                                                                    value="{{ old("name-$technology->id", $technology->name) }}"
                                                                    placeholder="Type new name...">
                                                                <input type="file" name="icon-{{ $technology->id }}"
                                                                    id="icon"
                                                                    class="form-control @error("icon-$technology->id", "update-$technology->id") is-invalid @enderror">
                                                            </div>

                                                            <button type="submit" class="btn btn-secondary">Edit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- delete - modal button --}}
                                    <div>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalId-{{ $technology->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </button>
                                    </div>

                                    {{-- delete - modal body --}}
                                    <div class="modal fade" id="modalId-{{ $technology->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $technology->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                {{-- modal header --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId-{{ $technology->id }}">
                                                        Delete Technology?
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                {{-- modal body --}}
                                                <div class="modal-body">
                                                    Are you sure you want to delete this technology? The action is
                                                    irreversible!
                                                </div>

                                                {{-- modal footer --}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form
                                                        action="{{ Route('admin.technologies.destroy', $technology->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')

                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td scope="row">Nothing to show</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
