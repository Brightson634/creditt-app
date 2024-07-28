<?php

namespace App\Http\Controllers\Webmaster;

// use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Entities\AccountingAccountType;
use Yajra\DataTables\Facades\DataTables;

class AccountTypeController extends Controller
{
    protected $accountingUtil;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $business_id = request()->session()->get('user.business_id');
        $business_id = $request->attributes->get('business_id');
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            $query = AccountingAccountType::where('account_type', request()->input('account_type'))
                        ->where(function ($q) use ($business_id) {
                            $q->whereNull('business_id')
                              ->orWhere('business_id', $business_id);
                        })
                        ->with('parent')
                        ->select(['name', 'description', 'id', 'business_id', 'parent_id', 'account_primary_type']);

            return Datatables::of($query)
                ->editColumn('name', function ($row) {
                    $html = '';

                    if (empty($row->business_id)) {
                        $html =$row->name;
                    } else {
                        $html = $row->name;
                    }

                    return $html;
                })
                ->editColumn('account_primary_type', function ($row) {
                    return $row->account_primary_type ;
                })
                ->addColumn('parent_type', function ($row) {
                    if (! empty($row->parent_id)) {
                        if (empty($row->business_id) && ! empty($row->description)) {
                            return$row->parent->name;
                        } else {
                            return $row->parent->name;
                        }
                    }
                })
                ->editColumn('description', function ($row) {
                    if (empty($row->business_id) && ! empty($row->description)) {
                        return $row->description;
                    } else {
                        return $row->description;
                    }
                })
                ->addColumn(
                    'action',
                    '@if(!empty($business_id))<div style="display:flex"><button
                        data-href="{{ action(\'\App\Http\Controllers\Webmaster\AccountTypeController@edit\', [$id]) }}"
                        class="btn btn-dark btn-sm tw-dw-btn tw-dw-btn-xs tw-dw-btn-outline tw-dw-btn-primary btn-modal"
                        data-container="#edit_account_type_modal" id="updateAccType" title="Update"><i
                            class="far fa-edit"
                           ></i></button>
                        &nbsp;
                        <button
                            data-href="{{ action(\'\App\Http\Controllers\Webmaster\AccountTypeController@destroy\', [$id]) }}"
                            class="btn btn-danger btn-sm tw-dw-btn tw-dw-btn-outline tw-dw-btn-xs tw-dw-btn-error delete_account_type_button"><i
                                class="far fa-trash-alt" title="Delete" data-toggle="tooltip-primary"></i></button></div>
                    @endif'
                )
                ->removeColumn('id')
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $business_id = $request->attributes->get('business_id');

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['name', 'description', 'account_type']);
            $input['business_id'] = $business_id;
            $input['created_by'] = $request->session()->get('user.id');
            $input['parent_id'] = ($input['account_type'] == 'detail_type') ? $request->input('parent_id') : null;

            $input['account_primary_type'] = ($input['account_type'] == 'sub_type') ? $request->input('account_primary_type') : null;

            $input['show_balance'] = ($input['account_type'] == 'sub_type') ? 1 : 0;

            $account_type = AccountingAccountType::create($input);
            $output = ['success' => true,
                'data' => $account_type,
                'msg' => 'Success',
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' =>'Something went wrong',
            ];
        }

        return $output;
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $business_id = $request->attributes->get('business_id');
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        $account_type = AccountingAccountType::find($id);
        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
                                              ->where(function ($q) use ($business_id) {
                                                  $q->whereNull('business_id')
                                                  ->orWhere('business_id', $business_id);
                                              })
                                               ->get();
        $view = view('webmaster.account_type.edit')
        ->with(compact('account_type', 'account_sub_types'))
        ->render();

        return response()->json(['html' => $view]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $business_id = $request->attributes->get('business_id');

        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        try {
            $input = $request->only(['name', 'description']);

            $account_type = AccountingAccountType::where('business_id', $business_id)
                                            ->find($id);

            $input['parent_id'] = $account_type->account_type == 'detail_type' ? $request->input('parent_id') : null;

            $account_type->update($input);
            $output = ['success' => true,
                'data' => $account_type,
                'msg' =>'Success',
            ];
        } catch (\Exception $e) {
            \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

            $output = ['success' => false,
                'msg' =>'Something went wrong',
            ];
        }

        return $output;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request,$id)
    {
         $business_id = $request->attributes->get('business_id');
        // if (! (auth()->user()->can('superadmin') ||
        //     $this->moduleUtil->hasThePermissionInSubscription($business_id, 'accounting_module'))) {
        //     abort(403, 'Unauthorized action.');
        // }

        if (request()->ajax()) {
            try {
                AccountingAccountType::where('business_id', $business_id)
                                      ->where('id', $id)
                                      ->delete();

                $output = ['success' => true,
                    'msg' => 'Deleted Successfully',
                ];
            } catch (\Exception $e) {
                \Log::emergency('File:'.$e->getFile().'Line:'.$e->getLine().'Message:'.$e->getMessage());

                $output = ['success' => false,
                    'msg' => 'something went wrong',
                ];
            }

            return $output;
        }
    }
}
