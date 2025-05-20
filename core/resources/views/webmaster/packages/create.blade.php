@php
    $modules = getPackageForModules();
@endphp
@extends('webmaster.partials.dashboard.main')
@section('title', 'Packages Create')
@section('content')
    <div class="row">
        <div class="col-xl-12 mx-auto bg-white">
            <h2 class="az-content-title">Create Package</h2>
            <form action="{{ route('webmaster.packages.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Package Name -->
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="package_name">
                                    <i class="fas fa-box"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Package Name" aria-label="Package Name" aria-describedby="package_name"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="package_price">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                step="0.01" placeholder="Price (Optional)" aria-label="Price"
                                aria-describedby="package_price" value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Trial Days -->
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="trial_days">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control @error('trial_days') is-invalid @enderror"
                                name="trial_days" placeholder="Trial Days" aria-label="Trial Days"
                                aria-describedby="trial_days" value="{{ old('trial_days', 0) }}" autocomplete="off">
                            @error('trial_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sort Order -->
                    <div class="col-lg-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="sort_order">
                                    <i class="fas fa-sort-numeric-up"></i>
                                </span>
                            </div>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror"
                                name="sort_order" placeholder="Sort Order" aria-label="Sort Order"
                                aria-describedby="sort_order" value="{{ old('sort_order', 0) }}" required>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Modules -->
                <div class="row">
                    <div class="col-lg-12">
                        <h5 class="az-content-title mg-b-10">Modules</h5>
                        @foreach ($modules as $module)
                            <div class="form-group">
                                <div class="form-check">

                                    <label class="ckbox" for="module_{{ $module }}">
                                        <input type="checkbox" name="modules[{{ $loop->index }}][name]"
                                            value="{{ $module }}" id="module_{{ $module }}"
                                            {{ old('modules.' . $loop->index . '.name') == $module ? 'checked' : '' }}><span>{{ ucfirst($module) }}</span>
                                    </label>
                                </div>
                                {{-- <div class="input-group mt-2 mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="max_{{ $module }}_accounts">
                                            <i class="fas fa-users"></i>
                                        </span>
                                    </div>
                                    <input type="number"
                                        name="modules[{{ $loop->index }}][limits][max_{{ $module }}_accounts]"
                                        class="form-control @error('modules.' . $loop->index . '.limits.max_' . $module . '_accounts') is-invalid @enderror"
                                        placeholder="Max {{ ucfirst($module) }} Accounts"
                                        aria-label="Max {{ ucfirst($module) }} Accounts"
                                        aria-describedby="max_{{ $module }}_accounts"
                                        value="{{ old('modules.' . $loop->index . '.limits.max_' . $module . '_accounts') }}">
                                    @error('modules.' . $loop->index . '.limits.max_' . $module . '_accounts')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                            </div>
                        @endforeach
                        @error('modules')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary">Save Package</button>
                        <a href="{{ route('webmaster.superadmin.package') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-3">

        </div><!-- col-3 -->
    </div>
@endsection
