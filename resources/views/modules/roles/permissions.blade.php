@extends('adminlte::page')
@section('title', 'User List')

@section('content')

<div class="row">
    <div class="col-lg-12 mt-3">
        <h4>Assign Permissions to Role: {{ ucfirst($role->name) }}</h4>

        @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
        @endif
        @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
        @endif

        <form action="{{ route('roles.permissions.sync', $role->id) }}" method="POST">
            @csrf

            <div class="row">
                @foreach ($permissions as $permission)
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]"
                            value="{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : ''
                        }}>
                        <label class="form-check-label" for="permissions[]">{{ $permission->name }}</label>
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary btn-sm mt-3">Update Permissions</button>
        </form>
    </div>
</div>
@endsection