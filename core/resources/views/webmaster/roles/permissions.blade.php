@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* General form and section styles */
        .card-header {
            background-color: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .card-header i {
            margin-right: 10px;
        }

        .card-body {
            background-color: #f9f9f9;
            padding: 20px;
        }

        .form-check {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 12px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            font-size: 1em;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Page heading */
        .page-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-heading h1 {
            font-size: 2em;
            color: #007bff;
            font-weight: bold;
        }

        /* Icons for permissions */
        .main-module-checkbox, .submodule-checkbox, .sub-permission-checkbox {
            transform: scale(1.2);
            margin-right: 10px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-check {
                margin-left: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <h1><i class="fas fa-key"></i> Assign or Update Permissions of {{ $role->name }} Role</h1>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('webmaster.role.assign.permissions.store', $role->id) }}" method="POST">
                @csrf
                @method('POST')

                @php
                    // Group permissions by module and submodule using the helper function
                    $groupedPermissions = [];
                    foreach ($permissions as $permission) {
                        $moduleInfo = getModule($permission->name);
                        if ($moduleInfo) {
                            $module = $moduleInfo['module'];
                            $submodule = $moduleInfo['submodule'];
                            $groupedPermissions[$module][$submodule][] = $permission;
                        }
                    }
                @endphp

                <div class="accordion" id="permissionsAccordion">
                    @foreach ($groupedPermissions as $module => $submodules)
                        <div class="card">
                            <!-- Accordion header with icon -->
                            <div class="card-header" id="heading{{ $module }}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $module }}" aria-expanded="false" aria-controls="collapse{{ $module }}">
                                        <i class="fas fa-folder"></i> {{ ucfirst($module) }} Permissions
                                    </button>
                                </h5>
                            </div>

                            <!-- Accordion content -->
                            <div id="collapse{{ $module }}" class="collapse" aria-labelledby="heading{{ $module }}" data-parent="#permissionsAccordion">
                                <div class="card-body">
                                    <!-- Main module checkbox with icon -->
                                    <div class="form-check">
                                        <input class="form-check-input main-module-checkbox" type="checkbox" id="main_module_{{ $module }}">
                                        <label class="form-check-label" for="main_module_{{ $module }}">
                                            <strong><i class="fas fa-cogs"></i> {{ ucfirst($module) }}</strong>
                                        </label>
                                    </div>

                                    <!-- Submodule permissions -->
                                    @foreach ($submodules as $submodule => $modulePermissions)
                                        <div class="form-check">
                                            <input class="form-check-input submodule-checkbox" type="checkbox" id="submodule_{{ $submodule }}">
                                            <label class="form-check-label" for="submodule_{{ $submodule }}">
                                                <strong><i class="fas fa-sitemap"></i> {{ ucfirst($submodule) }}</strong>
                                            </label>
                                        </div>
                                        <div class="row permission-group">
                                            @foreach ($modulePermissions as $permission)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input sub-permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" 
                                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                            {{ formatPermission($permission->name) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Assign/Update Permissions</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle the main module checkbox change event
            $('.main-module-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subModuleCheckboxes = $(this).closest('.card-body').find('.submodule-checkbox, .sub-permission-checkbox');
                subModuleCheckboxes.prop('checked', isChecked);
            });

            // Handle the submodule checkbox change event
            $('.submodule-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subPermissionCheckboxes = $(this).closest('.form-check').next('.permission-group').find('.sub-permission-checkbox');
                subPermissionCheckboxes.prop('checked', isChecked);
            });
        });
    </script>
@endsection
