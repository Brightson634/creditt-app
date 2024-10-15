@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .card {
            width: 100%;
        }

        /* Tabs styling */
        .az-nav-tabs .tab-item {
            flex-grow: 1;
            text-align: center;
            padding: 0 10px;
        }

        .az-nav-tabs .tab-link {
            font-size: 14px; 
            padding: 10px;
            display: block;
            color: #007bff;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .az-nav-tabs .tab-link.active {
            color: #000;
            border-bottom: 2px solid #007bff;
        }

        .permission-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }

        .permission-item {
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 5px;
            background-color: #f9f9f9;
            border-left: 5px solid transparent;
        }

        /* Color indicators */
        .permission-item.blue { border-color: #007bff; }
        .permission-item.green { border-color: #28a745; }
        .permission-item.red { border-color: #dc3545; }
        .permission-item.orange { border-color: #fd7e14; }

        .permission-icon {
            font-size: 18px;
            margin-right: 8px;
        }

        .permission-text {
            flex-grow: 1;
            margin-right: 10px;
        }

        /* Adjust checkbox positioning */
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-check-input {
            margin-right: 8px;
        }

        /* Module checkbox alignment */
        .module-checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            padding-left: 20px;
        }

        .submit-btn-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; 
        }

        @media (max-width: 768px) {
            .az-nav-tabs .tab-item {
                font-size: 12px;
            }

            .permission-item {
                flex: 1 1 calc(50% - 20px); 
            }
        }

        @media (max-width: 480px) {
            .permission-item {
                flex: 1 1 100%; 
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <h1><i class="fas fa-key"></i> Assign or Update Permissions of {{ $role->name }} Role</h1>
    </div>

    <div class="row">
        <div class="card bd-0">
            <div class="card-header card-header-tab">
                <div class="az-nav-tabs">
                    <div id="navComplex">
                        @php
                            // Group permissions by module and submodule
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
                        @foreach ($groupedPermissions as $module => $submodules)
                            <div class="tab-item">
                                <a href="#azTab{{ $loop->index }}"
                                    class="tab-link {{ $loop->first ? 'active' : '' }}">{{ ucfirst($module) }}
                                    Permissions</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div><!-- card-header -->

            <div class="card-body bd bd-t-0 pd-xl-25">
                <form action="{{ route('webmaster.role.assign.permissions.store', $role->id) }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="az-tab-content">
                        @foreach ($groupedPermissions as $module => $submodules)
                            <div id="azTab{{ $loop->index }}" class="az-tab-pane {{ $loop->first ? 'active' : '' }}">
                                <div class="module-checkbox-container">
                                    <input class="form-check-input main-module-checkbox" type="checkbox" id="module_{{ $loop->index }}">
                                    <label for="module_{{ $loop->index }}" style="margin-left: 5px;"><strong>Check All</strong></label>
                                </div>

                                @foreach ($submodules as $submodule => $modulePermissions)
                                    <div class="form-check">
                                        <input class="form-check-input submodule-checkbox" type="checkbox"
                                            id="submodule_{{ $submodule }}">
                                        <label class="form-check-label" for="submodule_{{ $submodule }}">
                                            <strong><i class="fas fa-sitemap"></i> {{ ucfirst($submodule) }}</strong>
                                        </label>
                                    </div>

                                    <div class="permission-container">
                                        @foreach ($modulePermissions as $permission)
                                            <div class="permission-item {{ $loop->index % 4 == 0 ? 'blue' : ($loop->index % 4 == 1 ? 'green' : ($loop->index % 4 == 2 ? 'red' : 'orange')) }}" style="height:40px;">
                                                <i class="fas fa-shield-alt permission-icon"></i>
                                                <div class="permission-text">
                                                    <label for="permission_{{ $permission->id }}">{{ formatPermission($permission->name) }}</label>
                                                </div>
                                                <input class="form-check-input sub-permission-checkbox" type="checkbox"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    id="permission_{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    <div class="submit-btn-container">
                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Assign/Update
                            Permissions</button>
                    </div>
                </form>
            </div><!-- card-body -->
        </div><!-- card -->
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle the main module checkbox change event
            $('.main-module-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const moduleContainer = $(this).closest('.az-tab-pane');

                // Check/uncheck all submodule and permission checkboxes
                moduleContainer.find('.submodule-checkbox, .sub-permission-checkbox').prop('checked', isChecked);
            });

            // Handle the submodule checkbox change event
            $('.submodule-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subPermissionCheckboxes = $(this).closest('.form-check').next('.permission-container')
                    .find('.sub-permission-checkbox');
                subPermissionCheckboxes.prop('checked', isChecked);
            });

            // Azia Tabs functionality
            $('.tab-link').on('click', function(e) {
                e.preventDefault();
                var tabId = $(this).attr('href');
                $('.tab-link').removeClass('active');
                $(this).addClass('active');
                $('.az-tab-pane').removeClass('active');
                $(tabId).addClass('active');
            });
        });
    </script>
@endsection
