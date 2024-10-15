@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .az-nav-tabs .tab-link {
            font-size: 16px;
            padding: 10px 15px;
            cursor: pointer;
            display: inline-block;
        }
        .az-tab-pane {
            padding: 20px;
        }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <h1><i class="fas fa-key"></i> Assign or Update Permissions of {{ $role->name }} Role</h1>
    </div>

    <div class="row">
        <div class="card bd-0 wd-280 wd-sm-500 wd-md-700 wd-xl-850">
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
                                <a href="#azTab{{ $loop->index }}" class="tab-link {{ $loop->first ? 'active' : '' }}">{{ ucfirst($module) }} Permissions</a>
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
                                <h6 class="tx-gray-900">{{ ucfirst($module) }} Permissions</h6>
                                
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
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Assign/Update Permissions</button>
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
                const subModuleCheckboxes = $(this).closest('.card-body').find('.submodule-checkbox, .sub-permission-checkbox');
                subModuleCheckboxes.prop('checked', isChecked);
            });

            // Handle the submodule checkbox change event
            $('.submodule-checkbox').change(function() {
                const isChecked = $(this).is(':checked');
                const subPermissionCheckboxes = $(this).closest('.form-check').next('.permission-group').find('.sub-permission-checkbox');
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
