@extends('webmaster.partials.dashboard.main')
@section('title')
    {{ $page_title }}
@endsection

@section('content')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
@endsection
@include('webmaster.partials.nav')
<section class="content-header">
    @include('webmaster.chart_of_accounts.create')
    <h1>Charts of Accounts</h1>
</section>
<section class="content">
    <div class="row mb-12">
        <div class="col-md-12">
            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-info active">
                    <input type="radio" name="view_type" value="tree" class="view_type">
                    <i class="fas fa-list-ul"></i>Tree View
                </label>
                <label class="btn btn-info">
                    <input type="radio" name="view_type" value="table" class="view_type">
                    <i class="fas fa-table"></i>Tabular View
                </label>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @component('webmaster.components.widget', ['class' => 'non'])
                @slot('tool')
                    <div class="box-tools">
                        <button class="btn btn-primary btn-sm addAcc" title='Add New Account'>
                            +Add
                        </button>
                    </div>
                @endslot
                <div id="accounts_tree"></div>
                <div id="tabular_view" class="hide">
                    <div class="row">
                        <div class="col-md-12">
                            @component('webmaster.components.filters', ['title' => 'Filters'])
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('account_type_filter', 'Account Type' . ':') !!}
                                        {!! Form::select('account_type_filter', $account_types, null, [
                                            'class' => 'form-control select2',
                                            'style' => 'width:100%',
                                            'id' => 'account_type_filter',
                                            'placeholder' => 'All',
                                        ]) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {!! Form::label('status_filter', 'Status' . ':') !!}
                                        {!! Form::select('status_filter', ['active' => 'Active', 'inactive' => 'Inactive'], null, [
                                            'class' => 'form-control select2',
                                            'style' => 'width:100%',
                                            'id' => 'status_filter',
                                            'placeholder' => 'All',
                                        ]) !!}
                                    </div>
                                </div>
                            @endcomponent
                        </div>
                    </div>
                    <div class="table-responsive" id="accounts_table">
                    </div>
                </div>
            @endcomponent
        </div>
    </div>
    <div id="edit_account_modal" class="modal">
        <div class="modal-dialog modal-lg" role="document" id='modalCont'>
        </div><!-- modal-dialog -->
    </div><!-- modal -->
</section>
@stop
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('select#account_currency').select2();

        $(document).on('click', '.addAcc', function() {
            $("#create_account_modal").modal('show');
        });
        load_accounts_table();
        load_accounts_table('tree');
    });

    $(document).on('change', '#account_type_filter, #status_filter', function() {
        load_accounts_table();
    });

    $('input[type=radio][name=view_type]').change(function() {
        if (this.value == 'tree') {
            $('#accounts_tree').removeClass('hide');
            $('#tabular_view').addClass('hide');
        } else if (this.value == 'table') {
            $('#accounts_tree').addClass('hide');
            $('#tabular_view').removeClass('hide');
        }
    });

    function load_accounts_table(view_type = 'table') {
        var data = {
            view_type: view_type
        };


        if ($('#account_type_filter').val() !== '') {
            data.account_type = $('#account_type_filter').val();
        }
        if ($('#status_filter').val() !== '') {
            data.status = $('#status_filter').val();
        }
        $.ajax({
            url: '{{ url('') }}/webmaster/accounting/chart-of-accounts',
            data: data,
            dataType: 'html',
            success: function(html) {
                if (view_type == 'table') {
                    $('#accounts_table').html(html);
                } else {
                    $('#accounts_tree').html(html);

                    $.jstree.defaults.core.themes.variant = "large";
                    $('#accounts_tree_container').jstree({
                        "core": {
                            "themes": {
                                "responsive": true
                            }
                        },
                        "types": {
                            "default": {
                                "icon": "fa fa-folder"
                            },
                            "file": {
                                "icon": "fa fa-file"
                            },
                        },
                        "plugins": ["types", "search"]
                    });

                    var to = false;
                    $('#accounts_tree_search').keyup(function() {
                        if (to) {
                            clearTimeout(to);
                        }
                        to = setTimeout(function() {
                            var v = $('#accounts_tree_search').val();
                            $('#accounts_tree_container').jstree(true).search(v);
                        }, 250);
                    });
                }
            },
        });
    };
    $(document).on('click', '#expand_all', function(e) {
        $('#accounts_tree_container').jstree("open_all");
    })
    $(document).on('click', '#collapse_all', function(e) {
        $('#accounts_tree_container').jstree("close_all");
    })

    $(document).on('shown.bs.modal', '#create_account_modal', function() {
        $(this).find('#account_sub_type').select2({
            dropdownParent: $('#create_account_modal')
        });
        $(this).find('#detail_type').select2({
            dropdownParent: $('#create_account_modal')
        });
        $(this).find('#parent_account').select2({
            dropdownParent: $('#create_account_modal')
        });
        $('#as_of').datepicker({
            autoclose: true,
            endDate: 'today',
        });
    });

    // $(document).on('hidden.bs.modal', '#create_account_modal', function(){
    //     tinymce.remove("#description");
    // });
    $(document).on('change', '#account_primary_type', function() {
        if ($(this).val() !== '') {
            $.ajax({
                url: '{{ url('') }}/webmaster/accounting/get-account-sub-types?account_primary_type=' +
                    $(this).val(),
                dataType: 'json',
                success: function(result) {

                    if ($('#account_sub_type').hasClass('select2-hidden-accessible')) {
                        $('#account_sub_type').select2('destroy');
                    }
                    $('#account_sub_type')
                        .empty()
                        .select2({
                            data: result.sub_types,
                            dropdownParent: $('#create_account_modal'),
                        }).on('change', function() {
                            if ($(this).select2('data')[0].show_balance == 1) {
                                $('#bal_div').removeClass('hide');
                            } else {
                                $('#bal_div').addClass('hide');
                            }
                        });
                    $('#account_sub_type').change();
                },
            });
        }
    });
    $(document).on('change', '#account_sub_type', function() {
        if ($(this).val() !== '') {
            $.ajax({
                url: '{{ url('') }}/webmaster/accounting/get-account-details-types?account_type_id=' +
                    $(this).val(),
                dataType: 'json',
                success: function(result) {
                    if ($('#detail_type').hasClass('select2-hidden-accessible')) {
                        $('#detail_type').select2('destroy');
                    }
                    $('#detail_type')
                        .empty()
                        .select2({
                            data: result.detail_types,
                            dropdownParent: $('#create_account_modal'),
                        }).on('change', function() {
                            if ($(this).val() !== '') {
                                var desc = $(this).select2('data')[0].description;
                                $('#detail_type_desc').html(desc);
                            }
                        });
                    $('#parent_account')
                        .empty()
                        .select2({
                            data: result.parent_accounts,
                            dropdownParent: $('#create_account_modal'),
                        });
                },
            });
        }
    })

   //update account
    $(document).on('click', '#updateAccount', function() {
            const updateUrl = $(this).data('href')
            $.ajax({
                url: updateUrl,
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    $('#modalCont').html(response.html);
                    $('#edit_account_modal').modal('show');
                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    toastr.error('Sorry Unexpected error has occured!')
                }
            });
        })
    $(document).on('click', 'a.activate-deactivate-btn', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json',
            success: function(response) {
                toastr.success(response.msg);
                load_accounts_table();
                load_accounts_table('tree');
            },
        });
    })
    $(document).on('click', 'a.ledger-link', function(e) {
        window.location.href = $(this).attr('href');
    });

</script>
@endsection
