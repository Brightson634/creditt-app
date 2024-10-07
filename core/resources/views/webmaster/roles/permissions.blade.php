@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <style>
        /* General form and section styles */
        .module-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            padding: 15px;
        }

        .module-header {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .submodule-header {
            font-size: 1.2em;
            font-weight: bold;
            margin-left: 20px;
            color: #555;
            margin-bottom: 8px;
        }

        .permission-group {
            margin-left: 40px;
            margin-top: 5px;
            margin-bottom: 10px;
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
        }

        /* Heading styles */
        .page-heading {
            text-align: center;
            margin-bottom: 30px;
        }

        .page-heading h1 {
            font-size: 2em;
            color: #007bff;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .permission-group {
                margin-left: 20px;
            }

            /* Ensure modules stack properly on smaller screens */
            .col-md-4 {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <h1>Assign or Update Permissions of {{ $role->name }} Role</h1>
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

                <div class="row">
                    @foreach ($groupedPermissions as $module => $submodules)
                        <div class="col-md-4"> <!-- Each module takes one-third of the row -->
                            <div class="module-card">
                                <div class="form-check">
                                    <input class="form-check-input module-checkbox" type="checkbox" id="module_{{ $module }}">
                                    <label class="form-check-label module-header" for="module_{{ $module }}">
                                        {{ ucfirst($module) }}
                                    </label>
                                </div>

                                @foreach ($submodules as $submodule => $modulePermissions)
                                    @if ($submodule)
                                        <div class="form-check submodule-header">
                                            <input class="form-check-input submodule-checkbox" type="checkbox"
                                                id="submodule_{{ $submodule }}">
                                            <label class="form-check-label" for="submodule_{{ $submodule }}">
                                                {{ ucfirst($submodule) }}
                                            </label>
                                        </div>
                                    @endif

                                    <div class="permission-group">
                                        @foreach ($modulePermissions as $permission)
                                            @php
                                                $formattedPermission = formatPermission($permission->name);
                                            @endphp
                                            <div class="form-check">
                                                <input class="form-check-input sub-permission-checkbox" type="checkbox"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    id="permission_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    {{ $formattedPermission }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if ($loop->iteration % 3 == 0) <!-- Close row after every third column -->
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Assign/Update Permissions</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle the module checkbox change event
            $('.module-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subCheckboxes = $(this).closest('.module-card').find('.sub-permission-checkbox');
                subCheckboxes.prop('checked', isChecked);
            });

            // Handle the submodule checkbox change event
            $('.submodule-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subPermissionCheckboxes = $(this).closest('.submodule-header').nextUntil(
                    '.submodule-header').find('.sub-permission-checkbox');
                subPermissionCheckboxes.prop('checked', isChecked);
            });
        });
    </script>
@endsection
