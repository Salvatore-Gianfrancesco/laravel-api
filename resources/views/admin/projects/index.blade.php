@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Projects</h1>
            <a href="{{ Route('admin.projects.create') }}" class="btn btn-primary new_project"><i
                    class="fa-solid fa-plus"></i></a>
        </div>

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
                        <th scope="col">Cover Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td scope="row">{{ $project->id }}</td>

                            <td>
                                @if ($project->cover_img)
                                    <img src="{{ asset('storage/' . $project->cover_img) }}" alt="{{ $project->title }}"
                                        width="100px">
                                @else
                                    <img src="https://via.placeholder.com/600x300.png?text=Cover+Image" alt="placeholder"
                                        width="100px">
                                @endif
                            </td>

                            <td>{{ $project->name }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ Route('admin.projects.show', $project->id) }}" class="btn btn-primary"><i
                                            class="fa-solid fa-eye"></i> Show</a>
                                    <a href="{{ Route('admin.projects.edit', $project->id) }}" class="btn btn-secondary"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</a>

                                    <!-- Modal trigger button -->
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#modalId-{{ $project->id }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId-{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId-{{ $project->id }}">Delete
                                                        project?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this project? The action is
                                                    irreversible!
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form action="{{ Route('admin.projects.destroy', $project->id) }}"
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
