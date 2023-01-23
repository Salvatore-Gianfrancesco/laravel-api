@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-start">
            <h1>Types</h1>

            {{-- form for creating a new type --}}
            <form action="{{ Route('admin.types.store') }}" method="post">
                @csrf

                <div class="d-flex align-items-center gap-2">
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Add new Type...">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i></button>
                </div>
            </form>
        </div>


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
                        <th scope="col">Name</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr>
                            {{-- type id --}}
                            <td scope="row">{{ $type->id }}</td>

                            {{-- type name --}}
                            <td>{{ $type->name }}</td>

                            {{-- edit and delete buttons --}}
                            <td>
                                <div class="d-flex gap-2">
                                    {{-- form for editing the type name --}}
                                    <form action="{{ Route('admin.types.update', $type->id) }}" method="post">
                                        @csrf
                                        @method('put')

                                        <div class="mb-3 d-flex align-items-center gap-2">
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" placeholder="Type new name...">
                                            <button type="submit" class="btn btn-secondary text-nowrap">Edit
                                                name</button>
                                        </div>
                                    </form>

                                    <!-- delete - modal button -->
                                    <div>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalId-{{ $type->id }}">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </div>

                                    <!-- delete - modal body -->
                                    <div class="modal fade" id="modalId-{{ $type->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $type->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitleId-{{ $type->id }}">
                                                        Delete Type?
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this type? The action is irreversible!
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form action="{{ Route('admin.types.destroy', $type->id) }}"
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
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
