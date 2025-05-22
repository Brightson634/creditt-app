@extends('webmaster.partials.dashboard.main')
@section('title', 'Superadmin Packages')
@section('content')
    <div class="row">
        @include('webmaster.partials.superadmin_nav')
    </div>

    <div class="row">
        <div class="col-xl-12 mx-auto bg-white ">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-sm-row">
                <h2 class="az-content-title">Manage Packages</h2>
                <a href="{{ route('webmaster.packages.create') }}" class="btn btn-primary btn-sm">Create Package</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Trial Days</th>
                        <th>Modules</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->price ? 'UGX-' . number_format($package->price, 2) : 'Free' }}</td>
                            <td>{{ $package->trial_days }}</td>
                            <td>{{ $package->modules->pluck('module_name')->implode(', ') }}</td>
                            <td>
                                <a href="{{ route('webmaster.packages.edit', $package) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
