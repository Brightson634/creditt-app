<style>
    .bg-light-green {
    background-color: #98D973 !important;
    color: #fff !important;
    }
.btn-group, .btn-group-vertical {
    position: relative !important;
    display: inline-block !important;
    vertical-align: middle !important;
}


button, html input[type="button"], input[type="reset"], input[type="submit"] {
    appearance: button !important;
    cursor: pointer !important;
}

</style>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Action</th>
            <th>Name</th>
            <th>General Ledger Code</th>
            <th>Parent Account</th>
            <th>Account Type</th>
            <th>Account Currency</th>
            <th>Account SubType</th>
            <th>Account Details</th>
            <!-- <th>@lang( 'accounting::lang.primary_balance' )</th> -->
            <th>Primary Balance</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($accounts as $account)
            <tr class="bg-gray">
                <td>
                    <div class="btn-group"><button type="button" class="btn btn btn-info active tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-info tw-w-max" data-toggle="dropdown" aria-expanded="false">Actions<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                        <ul class="dropdown-menu dropdown-menu-left" role="menu">
                            <li>
                                <a
                                href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'ledger'], $account->id)}}">
                                <i class="fas fa-file-alt"></i>Legder</a>
                            </li>

                            <li>
                                <a class="btn-modal"
                                href="#"
                                data-href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'edit'], $account->id)}}"
                                data-container="#create_account_modal" id='updateAccount'>
                                <i class="fas fa-edit"></i>Edit</a>
                            </li>
                            <li>
                                <a class="activate-deactivate-btn"
                                href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'activateDeactivate'], $account->id)}}">
                                    <i class="fas fa-power-off"></i>
                                    @if($account->status=='active') Deactivate @else
                                    Activate @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
                <td>{{$account->name}}</td>
                <td>{{$account->gl_code}}</td>
                <td></td>
                <td>@if(!empty($account->account_primary_type)){{ucfirst($account->account_primary_type)}}@endif</td>
                 <td>{{$account->account_currency}}</td>
                <td>
                    @if(!empty($account->account_sub_type))
                        {{$account->account_sub_type->name ? $account->account_sub_type->name : $account->account_sub_type->name}}
                    @endif
                </td>
                <td>
                    @if(!empty($account->detail_type))
                        {{$account->detail_type->name ? $account->detail_type->name : $account->detail_type->name}}
                    @endif
                </td>
                <td>@if(!empty($account->balance)) {{$account->balance}} @endif</td>
                <!-- <td></td> -->
                <td>@if($account->status == 'active')
                        <span class="label bg-light-green">Active</span>
                    @elseif($account->status == 'inactive')
                        <span class="label bg-red">Inactive</span>
                    @endif
                </td>
            </tr>
            @if(count($account->child_accounts) > 0)

                @foreach($account->child_accounts as $child_account)
                    <tr>
                        <td>
                        <div class="btn-group"><button type="button" class="btn btn-info active tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-info tw-w-max" data-toggle="dropdown" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
                            <ul class="dropdown-menu dropdown-menu-left" role="menu">
                                <li>
                                    <a
                                    href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'ledger'], $child_account->id)}}">
                                    <i class="fas fa-file-alt"></i>Ledger</a>
                                </li>
                                <li>
                                <a class="btn-modal"
                                    href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'edit'], $child_account->id)}}"
                                    data-href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'edit'], $child_account->id)}}"
                                    data-container="#create_account_modal">
                                    <i class="fas fa-edit"></i>Edit</a>
                                </li>
                                <li>
                                    <a class="activate-deactivate-btn"
                                    href="{{action([\App\Http\Controllers\Webmaster\CoaController::class, 'activateDeactivate'], $child_account->id)}}">
                                        <i class="fas fa-power-off"></i>
                                        @if($child_account->status=='active')Deactivate @else
                                        Activate @endif
                                    </a>
                                </li>
                            </ul>
                        </div>
                        </td>
                        <td style="padding-left:30px">{{$child_account->name}}</td>
                        <td>{{$child_account->gl_code}}</td>
                        <td>{{$account->name}}</td>
                        <td>@if(!empty($child_account->account_primary_type)){{ $child_account->account_primary_type}}@endif</td>
                         <td>{{$child_account->account_currency}}</td>
                        <td>
                            @if(!empty($child_account->account_sub_type))
                                {{ $child_account->account_sub_type->name ? $child_account->account_sub_type->name : $child_account->account_sub_type->name}}
                            @endif
                        </td>
                        <td>
                            @if(!empty($child_account->detail_type))
                                {{$child_account->detail_type->name ? $child_account->detail_type->name : $child_account->detail_type->name}}
                            @endif
                        </td>
                        <td>@if(!empty($child_account->balance)){{$child_account->balance}}@endif</td>
                        <!-- <td></td> -->
                        <td>
                            @if($child_account->status == 'active')
                                <span class="label bg-light-green">Active</span>
                            @elseif($child_account->status == 'inactive')
                                <span class="label bg-red">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif

        @endforeach

        @if(!$account_exist)
            <tr>
                <td colspan="10" class="text-center">
                    <h3>No accounts found</h3>
                    <p>Would you like us to create default accounts? Default accounts can be edited/deleted after they have been created</p>
                    <a href="{{route('webmaster.accounting.create-default-accounts')}}" class="tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline  tw-dw-btn-accent">Create Default Accounts <i class="fas fa-file-import"></i></a>
                </td>
            </tr>
        @endif
    </tbody>
</table>

{{-- <script>
$(document).ready(function () {
     const accounts=@json($accounts);
     console.log(accounts);
});
</script> --}}
