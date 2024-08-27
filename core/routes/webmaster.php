<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Webmaster\CoaController;
use App\Http\Controllers\Webmaster\FeeController;

use App\Http\Controllers\Webmaster\AuthController;
use App\Http\Controllers\Webmaster\LoanController;
use App\Http\Controllers\Webmaster\RoleController;
use App\Http\Controllers\Webmaster\AssetController;
use App\Http\Controllers\Webmaster\GroupController;
use App\Http\Controllers\Webmaster\ShareController;
use App\Http\Controllers\Webmaster\BranchController;
use App\Http\Controllers\Webmaster\BudgetController;
use App\Http\Controllers\Webmaster\LenderController;
use App\Http\Controllers\Webmaster\MemberController;
use App\Http\Controllers\Webmaster\ReportController;
use App\Http\Controllers\Webmaster\SavingController;
use App\Http\Controllers\Webmaster\CompanyController;
use App\Http\Controllers\Webmaster\ExpenseController;

use App\Http\Controllers\Webmaster\LoanFeeController;
use App\Http\Controllers\Webmaster\ProfileController;
use App\Http\Controllers\Webmaster\SettingController;
use App\Http\Controllers\Webmaster\TaxRateController;
use App\Http\Controllers\Webmaster\BuyShareController;
use App\Http\Controllers\Webmaster\DbBackupController;
use App\Http\Controllers\Webmaster\FeeRangeController;


use App\Http\Controllers\Webmaster\InvestorController;
use App\Http\Controllers\Webmaster\SupplierController;
use App\Http\Controllers\Webmaster\TransferController;
use App\Http\Controllers\Webmaster\DashboardController;
use App\Http\Controllers\Webmaster\GroupLoanController;
use App\Http\Controllers\Webmaster\SavingFeeController;
use App\Http\Controllers\Webmaster\SellShareController;
use App\Http\Controllers\Webmaster\AccountingController;
use App\Http\Controllers\Webmaster\AssetGroupController;





use App\Http\Controllers\Webmaster\InvestmentController;
use App\Http\Controllers\Webmaster\MemberTypeController;
use App\Http\Controllers\Webmaster\SocialFundController;
use App\Http\Controllers\Webmaster\UserIncomeController;
use App\Http\Controllers\Webmaster\AccountTypeController;
use App\Http\Controllers\Webmaster\ApprovalPinController;
use App\Http\Controllers\Webmaster\BankAccountController;
use App\Http\Controllers\Webmaster\ItemForSaleController;
use App\Http\Controllers\Webmaster\LoanPaymentController;
use App\Http\Controllers\Webmaster\LoanProductController;
use App\Http\Controllers\Webmaster\PaymentModeController;
use App\Http\Controllers\Webmaster\PayslipTypeController;
use App\Http\Controllers\Webmaster\SettingsAccController;
use App\Http\Controllers\Webmaster\StaffMemberController;
use App\Http\Controllers\Webmaster\TransactionController;
use App\Http\Controllers\Webmaster\UserExpenseController;
use App\Http\Controllers\Webmaster\JournalEntryController;
use App\Http\Controllers\Webmaster\OrganizationController;
use App\Http\Controllers\Webmaster\ShareAccountController;
use App\Http\Controllers\Webmaster\BorrowProductController;
use App\Http\Controllers\Webmaster\MemberAccountController;
use App\Http\Controllers\Webmaster\PaymentMethodController;
use App\Http\Controllers\Webmaster\SavingProductController;

use App\Http\Controllers\Webmaster\ShareCategoryController;
use App\Http\Controllers\Webmaster\AccountDepositController;
use App\Http\Controllers\Webmaster\BranchPositionController;
use App\Http\Controllers\Webmaster\ChartOfAccountController;
use App\Http\Controllers\Webmaster\CollateralTypeController;
use App\Http\Controllers\Webmaster\InvestmentPlanController;

// use App\Http\Controllers\Webmaster\JournalEntryController;
use App\Http\Controllers\Webmaster\JournalAccountController;
use App\Http\Controllers\Webmaster\PaymentAccountController;
use App\Http\Controllers\Webmaster\PayrollSettingController;
use App\Http\Controllers\Webmaster\AccountTransferController;

use App\Http\Controllers\Webmaster\AllowanceOptionController;
use App\Http\Controllers\Webmaster\ApprovalSettingController;
use App\Http\Controllers\Webmaster\DeductionOptionController;
use App\Http\Controllers\Webmaster\ExpenseCategoryController;
use App\Http\Controllers\Webmaster\LoanDocumentTypeController;
use App\Http\Controllers\Webmaster\SubscriptionPlanController;
use App\Http\Controllers\Webmaster\UserDocumentTypeController;
use App\Http\Controllers\Webmaster\ChartOfAccountTypeController;
use App\Http\Controllers\Webmaster\HelpdeskController;
use App\Http\Controllers\Webmaster\TransactionChannelController;
use App\Http\Controllers\Webmaster\LoanProvisionSettingController;
use Illuminate\Support\Facades\Mail;


Route::prefix('webmaster')->name('webmaster.')->group(function ()
{

   Route::get('/',  [AuthController::class, 'loginForm'])->name('login');
   Route::post('/login',           [AuthController::class,'login'])->name('login.submit');

    Route::middleware(['auth:webmaster','setUser'])->group(function()
   {
      Route::get('/dashboard',       [DashboardController::class,'index'])->name('dashboard');
      Route::get('/profile',   [ProfileController::class,'profile'])->name('profile');
      Route::post('/profile/update',  [ProfileController::class,'profileupdate'])->name('profile.update');
      Route::post('/profile-image',  [ProfileController::class,'profileimage'])->name('profile.image');
      Route::post('/password/update', [ProfileController::class,'updatepassword'])->name('password.update');
      Route::get('/notifications', [DashboardController::class,'notifications'])->name('notifications');
      Route::get('/notification/{id}', [DashboardController::class,'notificationread'])->name('notification.read');
      Route::get('/logout',[ProfileController::class,'logout'])->name('logout');
      Route::get('/help/desk',[HelpdeskController::class,'index'])->name('desk.help');

      //Settings
      Route::get('/settings/generalsetting',   [SettingController::class,'generalsetting'])->name('generalsetting');
      Route::get('/settings/exchangerate', [SettingController::class,'settingExchangerate'])->name('exchangerates');
      Route::post('/settings/generalsetting', [SettingController::class,'updateGeneralSetting'])->name('generalsetting.update');
      Route::get('/settings/emailsetting',   [SettingController::class,'emailsetting'])->name('emailsetting');
      Route::post('/settings/emailsetting', [SettingController::class,'updateEmailSetting'])->name('emailsetting.update');

      Route::get('/settings/smssetting',   [SettingController::class,'smssetting'])->name('smssetting');
      Route::post('/settings/smssetting', [SettingController::class,'updateSmsSetting'])->name('smssetting.update');


      Route::get('/settings/logosetting',   [SettingController::class,'logosetting'])->name('logosetting');
      Route::post('/settings/logo', [SettingController::class,'updateLogo'])->name('logo.update');
      Route::post('/settings/footerlogo', [SettingController::class,'updateFooterLogo'])->name('footerlogo.update');
      Route::post('/settings/favicon', [SettingController::class,'updateFavicon'])->name('favicon.update');
      Route::post('/settings/mainphoto', [SettingController::class,'updateMainPhoto'])->name('mainphoto.update');
      Route::post('/sendtestemail', [SettingController::class,'sendTestEmail'])->name('send.testemail');
      Route::post('/exchangerate/save',[SettingController::class,'saveExchangeRate'])->name('exchangerate.save');
      Route::get('/exchangerate/get/',[SettingController::class,'getExchangeRateToUpdate'])->name('exchangerate.get');
      Route::post('/exchangerate/update/',[SettingController::class,'updateExchangeRate'])->name('exchangerate.update');
      Route::delete('/exchangerate/delete/',[SettingController::class,'deleteRate'])->name('exchangerate.delete');
      Route::get('/settings/prefixsetting',[SettingController::class,'prefixSettingView'])->name('prefixsetting');
      Route::post('/settings/prefix/save', [SettingController::class,'savePrefixSettings'])->name('prefix.settings.save');
      Route::delete('/settings/prefix/delete', [SettingController::class,'deletePrefixSettings'])->name('prefix.settings.delete');
      Route::get('/accounttypes',  [ChartOfAccountTypeController::class,'accounttypes'])->name('accounttypes');
      Route::post('/accounttype/store',        [ChartOfAccountTypeController::class,'accounttypeStore'])->name('accounttype.store');
      Route::post('/accounttype/update',       [ChartOfAccountTypeController::class,'accounttypeUpdate'])->name('accounttype.update');

      Route::get('/chartofaccounts',  [ChartOfAccountController::class,'chartofaccounts'])->name('chartofaccounts');
      Route::get('/accounting/overview', [AccountingController::class,'dashboard'])->name('overview');
      Route::get('accounts-dropdown', [AccountingController::class,
        'AccountsDropdown'])->name('accounts-dropdown');
      Route::get('/chartofaccount/create',   [ChartOfAccountController::class,'chartofaccountCreate'])->name('chartofaccount.create');
      Route::post('/chartofaccount/store',     [ChartOfAccountController::class,'chartofaccountStore'])->name('chartofaccount.store');
      Route::get('/chartofaccount/edit/{id}',  [ChartOfAccountController::class,'chartofaccountEdit'])->name('chartofaccount.edit');
      Route::post('/chartofaccount/update',       [ChartOfAccountController::class,'chartofaccountUpdate'])->name('chartofaccount.update');
      Route::get('/chartofaccount/accountbook/{id}',  [ChartOfAccountController::class,'chartofaccountAccountbook'])->name('chartofaccount.accountbook');

      Route::get('/accounting/chart-of-accounts',[CoaController::class,'index'])->name('accounting.chart_of_accounts');
      Route::get('/accounting/create',[CoaController::class,'create'])->name('accounting.create');
      Route::get('/accounting/edit/{id}',[CoaController::class,'edit'])->name('accounting.edit');
      Route::get('/accounting/activate/{id}',[CoaController::class,'activateDeactivate'])->name('accounting.activate');
      Route::get('ledger/{id}', [CoaController::class,
      'ledger'])->name('accounting.ledger');
      Route::post('/accounting/store',[CoaController::class,'store'])->name('accounting.store');
      Route::get('/accounting/get-account-sub-types', [CoaController::class,
        'getAccountSubTypes']);
      Route::get('/accounting/get-account-details-types', [CoaController::class,
    'getAccountDetailsType']);
      Route::put('/accounting/update/{id}', [CoaController::class,
         'update']);
      Route::get('create-default-accounts', [CoaController::class,
    'createDefaultAccounts'])->name('accounting.create-default-accounts');

      //journals
      Route::get('/journalentries',  [JournalEntryController::class,'journalentries'])->name('journalentries');
      Route::get('/journalentry/create',   [JournalEntryController::class,'create'])->name('journalentry.create');
      Route::post('/journalentry/store',     [JournalEntryController::class,'store'])->name('journalentry.store');
      Route::get('{id}/edit',  [JournalEntryController::class,'edit']);
      Route::delete('{id}/destroy', [JournalEntryController::class,'destroy']);
      Route::get('{id}/show', [JournalEntryController::class,'show']);
      Route::get('{id}/reverse', [JournalEntryController::class,'reverse']);
      Route::put('{id}/update', [JournalEntryController::class,'update']);
      Route::post('/journalentry/update',    [JournalEntryController::class,'journalentryUpdate'])->name('journalentry.update');
    //  Route::resource('journal-entry',JournalEntryController::class);
     Route::get('accounting/journal-entry',[JournalEntryController::class,'index'])->name('journal-entry.index');
     //transfers
      Route::resource('transfer',TransferController::class)->except(['show']);

      //budget
      Route::resource('budget',BudgetController::class)->except(['show', 'edit',
        'update', 'destroy']);
      //reports
       Route::get('reports', [ReportController::class, 'index']);
       Route::get('reports/trial-balance', [ReportController::class,
       'trialBalance'])->name('accounting.trialBalance');
       Route::get('reports/balance-sheet', [ReportController::class,
       'balanceSheet'])->name('accounting.balanceSheet');
       Route::get('reports/account-receivable-ageing-report',
       [ReportController::class,
       'accountReceivableAgeingReport'])->name('accounting.account_receivable_ageing_report');
       Route::get('reports/account-receivable-ageing-details',
       [ReportController::class,
       'accountReceivableAgeingDetails'])->name('accounting.account_receivable_ageing_details');
       Route::get('reports/account-payable-ageing-report',
       [ReportController::class,
       'accountPayableAgeingReport'])->name('accounting.account_payable_ageing_report');
       Route::get('reports/account-payable-ageing-details',
       [ReportController::class,
       'accountPayableAgeingDetails'])->name('accounting.account_payable_ageing_details');

      //transactions
       Route::get('transactions', [TransactionController::class, 'index']);
       Route::get('transactions/map', [TransactionController::class, 'map']);
       Route::post('transactions/save-map', [TransactionController::class,
       'saveMap']);
       Route::get('settings', [SettingsAccController::class, 'index']);
       Route::get('reset-data', [SettingsAccController::class,
              'resetData']);
       //settings and expenses
       Route::post('save-settings', [SettingsAccController::class, 'saveSettings']);
       Route::get('/expensecategories',  [ExpenseCategoryController::class,'expensecategories'])->name('expensecategories');
      Route::post('/expensecategory/store',        [ExpenseCategoryController::class,'expensecategoryStore'])->name('expensecategory.store');
      Route::post('/expensecategory/update',       [ExpenseCategoryController::class,'update'])->name('expensecategory.update');
      Route::get('/expensecategory/edit/{id}',[ExpenseCategoryController::class,'edit']);


      Route::get('/expenses',        [ExpenseController::class,'expenses'])->name('expenses');
      Route::get('/expense/create',   [ExpenseController::class,'expenseCreate'])->name('expense.create');
      Route::post('/expense/store',     [ExpenseController::class,'expenseStore'])->name('expense.store');
      Route::get('/expense/edit/{id}',  [ExpenseController::class,'expenseEdit'])->name('expense.edit');
      Route::post('/expense/update',    [ExpenseController::class,'expenseUpdate'])->name('expense.update');
      Route::post('/expense/refund/store',     [ExpenseController::class,'expenseRefundStore'])->name('expenserefund.store');

      Route::get('/accounttransfers',  [AccountTransferController::class,'accounttransfers'])->name('accounttransfers');
      Route::post('/accounttransfer/store',        [AccountTransferController::class,'accounttransferStore'])->name('accounttransfer.store');
      Route::post('/accounttransfer/update',       [AccountTransferController::class,'accounttransferUpdate'])->name('accounttransfer.update');
      Route::get('/accounttransfer/getcreditaccounts/{id}',  [AccountTransferController::class,'creditAccounts'])->name('accounttransfer.accounts');

      Route::get('/accountdeposits',  [AccountDepositController::class,'accountdeposits'])->name('accountdeposits');
      Route::post('/accountdeposit/store',        [AccountDepositController::class,'accountdepositStore'])->name('accountdeposit.store');
      Route::post('/accountdeposit/update',       [AccountDepositController::class,'accountdepositUpdate'])->name('accountdeposit.update');

       //Loan Payments
        Route::get('loanpayments',       [LoanPaymentController::class,'loanpayments'])->name('loanpayments');
        Route::get('loanpayment/create',   [LoanPaymentController::class,'loanpaymentCreate'])->name('loanpayment.create');
        Route::post('loanpayment/store',       [LoanPaymentController::class,'loanpaymentStore'])->name('loanpayment.store');
        Route::get('loanpayment/edit/{id}',       [LoanPaymentController::class,'loanpaymentEdit'])->name('loanpayment.edit');
        Route::post('loanpayment/update',       [LoanPaymentController::class,'loanpaymentUpdate'])->name('loanpayment.update');
        Route::get('/loanpayment/member/{id}', [LoanPaymentController::class,'loanMember'])->name('loan.member');
        Route::get('/loanpayment/receipt/{id}', [LoanPaymentController::class,'loanPaymentReceiptDownload'])->name('loan.receipt');
        Route::post('/loanpayment/info', [LoanPaymentController::class,'loanPaymentInfo'])->name('loanpayment.info');

      // Memberss
      Route::get('/members',        [MemberController::class,'members'])->name('members');
      Route::get('/member/create',   [MemberController::class,'memberCreate'])->name('member.create');
      Route::post('/member/store',     [MemberController::class,'memberStore'])->name('member.store');
      Route::get('/member/edit/{id}',  [MemberController::class,'memberEdit'])->name('member.edit');
      Route::post('/member/update',    [MemberController::class,'memberUpdate'])->name('member.update');

      Route::post('/member/individual/update',    [MemberController::class,'memberIndividualUpdate'])->name('member.individual.update');
      Route::post('/member/biodata/update',    [MemberController::class,'memberBiodataUpdate'])->name('member.biodata.update');
      Route::post('/member/group/update',    [MemberController::class,'memberGroupUpdate'])->name('member.group.update');

      Route::get('/member/dashboard/{id}', [MemberController::class,'memberDashboard'])->name('member.dashboard');
      Route::post('/member/photo/update',    [MemberController::class,'memberPhotoUpdate'])->name('memberphoto.update');
      Route::post('/member/contact/store',     [MemberController::class,'memberContactStore'])->name('membercontact.store');
      Route::post('/member/contact/delete',     [MemberController::class,'memberContactDelete'])->name('membercontact.delete');
      Route::post('/member/email/store',     [MemberController::class,'memberEmailStore'])->name('memberemail.store');
      Route::post('/member/email/delete',     [MemberController::class,'memberEmailDelete'])->name('memberemail.delete');
       Route::post('/member/document/store',     [MemberController::class,'memberDocumentStore'])->name('memberdocument.store');
      Route::post('/member/document/delete',     [MemberController::class,'memberDocumentDelete'])->name('memberdocument.delete');
      Route::post('/member/groupmember/store',     [MemberController::class,'groupmemberStore'])->name('groupmember.store');
      Route::post('/member/groupmember/update',  [MemberController::class,'groupmemberEdit'])->name('groupmember.update');
      Route::post('/member/groupmember/delete',     [MemberController::class,'groupmemberDelete'])->name('groupmember.delete');


      Route::get('branchpositions',       [BranchPositionController::class,'branchpositions'])->name('branchpositions');
      Route::post('branchposition/store',       [BranchPositionController::class,'branchpositionStore'])->name('branchposition.store');
      Route::post('branchposition/update',       [BranchPositionController::class,'branchpositionUpdate'])->name('branchposition.update');

      // Branches
      Route::get('/branches',        [BranchController::class,'branches'])->name('branches');
      Route::get('/branch/create',   [BranchController::class,'branchCreate'])->name('branch.create');
      Route::post('/branch/store',     [BranchController::class,'branchStore'])->name('branch.store');
      Route::post('/branch/edit',  [BranchController::class,'branchEdit'])->name('branch.edit');
      Route::post('/branch/update',    [BranchController::class,'branchUpdate'])->name('branch.update');

      Route::get('/staffs',        [StaffMemberController::class,'staffs'])->name('staffs');
      Route::get('/staff/create',   [StaffMemberController::class,'staffCreate'])->name('staff.create');
      Route::post('/staff/store',     [StaffMemberController::class,'staffStore'])->name('staff.store');
      Route::get('/staff/edit/{id}',  [StaffMemberController::class,'staffEdit'])->name('staff.edit');
      Route::post('/staff/update',    [StaffMemberController::class,'staffUpdate'])->name('staff.update');
      Route::get('/staff/dashboard/{id}', [StaffMemberController::class,'staffDashboard'])->name('staff.dashboard');

      Route::post('/staff/photo/update',    [ProfileController::class,'staffPhotoUpdate'])->name('staffphoto.update');
      Route::post('/staff/signature/update',    [ProfileController::class,'staffSignatureUpdate'])->name('staffsignature.update');
      Route::post('/staff/information/update',    [ProfileController::class,'staffInformationUpdate'])->name('staffinformation.update');
      Route::post('/staff/biodata/update',    [ProfileController::class,'staffBiodataUpdate'])->name('staffbiodata.update');
      Route::post('/staff/contact/store',     [ProfileController::class,'staffContactStore'])->name('staffcontact.store');
      Route::post('/staff/contact/delete',     [ProfileController::class,'staffContactDelete'])->name('staffcontact.delete');
      Route::post('/staff/email/store',     [ProfileController::class,'staffEmailStore'])->name('staffemail.store');
      Route::post('/staff/email/delete',     [ProfileController::class,'staffEmailDelete'])->name('staffemail.delete');
       Route::post('/staff/document/store',     [ProfileController::class,'staffDocumentStore'])->name('staffdocument.store');
      Route::post('/staff/document/delete',     [ProfileController::class,'staffDocumentDelete'])->name('staffdocument.delete');

      Route::get('/investors',        [InvestorController::class,'investors'])->name('investors');
      Route::get('/investor/create',   [InvestorController::class,'investorCreate'])->name('investor.create');
      Route::post('/investor/store',     [InvestorController::class,'investorStore'])->name('investor.store');
      Route::get('/investor/edit/{id}',  [InvestorController::class,'investorEdit'])->name('investor.edit');
      Route::post('/investor/update',    [InvestorController::class,'investorUpdate'])->name('investor.update');
      Route::get('/investor/dashboard/{id}',  [InvestorController::class,'investorDashboard'])->name('investor.dashboard');

      Route::get('/assets',        [AssetController::class,'assets'])->name('assets');
      Route::get('/asset/create',   [AssetController::class,'assetCreate'])->name('asset.create');
      Route::post('/asset/store',     [AssetController::class,'assetStore'])->name('asset.store');
      Route::get('/asset/edit/{id}',  [AssetController::class,'assetEdit'])->name('asset.edit');
      Route::post('/asset/update',    [AssetController::class,'assetUpdate'])->name('asset.update');

      Route::get('/assetgroups',        [AssetGroupController::class,'assetgroups'])->name('assetgroups');
      Route::get('/assetgroup/create',   [AssetGroupController::class,'assetgroupCreate'])->name('assetgroup.create');
      Route::post('/assetgroup/store',     [AssetGroupController::class,'assetgroupStore'])->name('assetgroup.store');
      Route::get('/assetgroup/edit/{id}',  [AssetGroupController::class,'assetgroupEdit'])->name('assetgroup.edit');
      Route::post('/assetgroup/update',    [AssetGroupController::class,'assetgroupUpdate'])->name('assetgroup.update');

      Route::get('/subscriptionplans',        [SubscriptionPlanController::class,'subscriptionplans'])->name('subscriptionplans');
      Route::get('/subscriptionplan/create',   [SubscriptionPlanController::class,'subscriptionplanCreate'])->name('subscriptionplan.create');
      Route::post('/subscriptionplan/store',     [SubscriptionPlanController::class,'subscriptionplanStore'])->name('subscriptionplan.store');
      Route::get('/subscriptionplan/edit/{id}',  [SubscriptionPlanController::class,'subscriptionplanEdit'])->name('subscriptionplan.edit');
      Route::post('/subscriptionplan/update',    [SubscriptionPlanController::class,'subscriptionplanUpdate'])->name('subscriptionplan.update');

      Route::get('/suppliers',        [SupplierController::class,'suppliers'])->name('suppliers');
      Route::get('/supplier/create',   [SupplierController::class,'supplierCreate'])->name('supplier.create');
      Route::post('/supplier/store',     [SupplierController::class,'supplierStore'])->name('supplier.store');
      Route::get('/supplier/edit/{id}',  [SupplierController::class,'supplierEdit'])->name('supplier.edit');
      Route::post('/supplier/update',    [SupplierController::class,'supplierUpdate'])->name('supplier.update');

      Route::get('/fees',              [FeeController::class,'fees'])->name('fees');
      Route::get('/fee/create',        [FeeController::class,'feeCreate'])->name('fee.create');
      Route::post('/fee/store',        [FeeController::class,'feeStore'])->name('fee.store');
      Route::get('/fee/edit/{id}',     [FeeController::class,'feeEdit'])->name('fee.edit');
      Route::post('/fee/update',       [FeeController::class,'feeUpdate'])->name('fee.update');

      Route::get('/feeranges',              [FeeRangeController::class,'feeranges'])->name('feeranges');
      Route::get('/feerange/create',        [FeeRangeController::class,'feerangeCreate'])->name('feerange.create');
      Route::post('/feerange/store',        [FeeRangeController::class,'feerangeStore'])->name('feerange.store');
      Route::get('/feerange/edit/{id}',     [FeeRangeController::class,'feerangeEdit'])->name('feerange.edit');
      Route::post('/feerange/update',       [FeeRangeController::class,'feerangeUpdate'])->name('feerange.update');

      Route::get('/shares',              [ShareController::class,'shares'])->name('shares');
      Route::get('/share/create',        [ShareController::class,'shareCreate'])->name('share.create');
      Route::post('/share/store',        [ShareController::class,'shareStore'])->name('share.store');
      Route::get('/share/edit/{id}',     [ShareController::class,'shareEdit'])->name('share.edit');
      Route::post('/share/update',       [ShareController::class,'shareUpdate'])->name('share.update');

      Route::get('/buyshares',              [BuyShareController::class,'buyshares'])->name('buyshares');
      Route::get('/buyshare/create',        [BuyShareController::class,'buyshareCreate'])->name('buyshare.create');
      Route::post('/buyshare/store',        [BuyShareController::class,'buyshareStore'])->name('buyshare.store');
      Route::get('/buyshare/edit/{id}',     [BuyShareController::class,'buyshareEdit'])->name('buyshare.edit');
      Route::post('/buyshare/update',       [BuyShareController::class,'buyshareUpdate'])->name('buyshare.update');
      Route::get('/buyshare/share/{id}',     [BuyShareController::class,'getShare'])->name('buyshare.get');

      Route::get('/sellshares',          [SellShareController::class,'sellshares'])->name('sellshares');
      Route::get('/sellshare/create',        [SellShareController::class,'sellshareCreate'])->name('sellshare.create');
      Route::post('/sellshare/store',        [SellShareController::class,'sellshareStore'])->name('sellshare.store');
      Route::get('/sellshare/edit/{id}',     [SellShareController::class,'sellshareEdit'])->name('sellshare.edit');
      Route::post('/sellshare/update',       [SellShareController::class,'sellshareUpdate'])->name('sellshare.update');
      // Route::get('/sellshare/share/{id}',     [BuyShareController::class,'getShare'])->name('sellshare.get');


      Route::get('/investments',        [InvestmentController::class,'investments'])->name('investments');
      Route::get('/investment/create',   [InvestmentController::class,'investmentCreate'])->name('investment.create');
      Route::post('/investment/store',     [InvestmentController::class,'investmentStore'])->name('investment.store');
      Route::get('/investment/edit/{id}',  [InvestmentController::class,'investmentEdit'])->name('investment.edit');
      Route::post('/investment/update',    [InvestmentController::class,'investmentUpdate'])->name('investment.update');
      Route::get('/investment/dashboard/{id}',  [InvestmentController::class,'investmentDashboard'])->name('investment.dashboard');
      Route::post('/investment/investor/store',     [InvestmentController::class,'investmentInvestorStore'])->name('investment.investor.store');
      Route::post('/investment/document/store',     [InvestmentController::class,'investmentDocumentStore'])->name('investmentdocument.store');
      Route::post('/investment/document/delete',     [InvestmentController::class,'investmentDocumentDelete'])->name('investmentdocument.delete');

      Route::get('/investmentplans',        [InvestmentPlanController::class,'investmentplans'])->name('investmentplans');
      Route::get('/investmentplan/create',   [InvestmentPlanController::class,'investmentplanCreate'])->name('investmentplan.create');
      Route::post('/investmentplan/store',     [InvestmentPlanController::class,'investmentplanStore'])->name('investmentplan.store');
      Route::get('/investmentplan/edit/{id}',  [InvestmentPlanController::class,'investmentplanEdit'])->name('investmentplan.edit');
      Route::post('/investmentplan/update',    [InvestmentPlanController::class,'investmentplanUpdate'])->name('investmentplan.update');

      Route::get('/groups',        [GroupController::class,'groups'])->name('groups');
      Route::get('/group/create',   [GroupController::class,'groupCreate'])->name('group.create');
      Route::post('/group/store',     [GroupController::class,'groupStore'])->name('group.store');
      Route::get('/group/edit/{id}',  [GroupController::class,'groupEdit'])->name('group.edit');
      Route::post('/group/update',    [GroupController::class,'groupUpdate'])->name('group.update');

      Route::get('/savings',        [SavingController::class,'savings'])->name('savings');
      Route::get('/saving/create',   [SavingController::class,'savingCreate'])->name('saving.create');
      Route::post('/saving/store',     [SavingController::class,'savingStore'])->name('saving.store');
      Route::get('/saving/edit/{id}',  [SavingController::class,'savingEdit'])->name('saving.edit');
      Route::post('/saving/update',    [SavingController::class,'savingUpdate'])->name('saving.update');
      Route::get('/saving/getaccounts/{id}',  [SavingController::class,'savingAccounts'])->name('saving.accounts');

      Route::get('/saving/pdf',   [SavingController::class,'savingPdf'])->name('saving.pdf');

       Route::resource('account-type',AccountTypeController::class);

      // Route::get('/accounttypes',    [AccountTypeController::class,'accounttypes'])->name('accounttypes');
      // Route::get('/accounttype/create',   [AccountTypeController::class,'accounttypeCreate'])->name('accounttype.create');
      // Route::post('/accounttype/store',     [AccountTypeController::class,'accounttypeStore'])->name('accounttype.store');
      // Route::get('/accounttype/edit/{id}',  [AccountTypeController::class,'accounttypeEdit'])->name('accounttype.edit');
      // Route::post('/accounttype/update',    [AccountTypeController::class,'accounttypeUpdate'])->name('accounttype.update');


      Route::get('/companies',        [CompanyController::class,'companies'])->name('companies');
      Route::get('/company/create',   [CompanyController::class,'companyCreate'])->name('company.create');
      Route::post('/company/store',     [CompanyController::class,'companyStore'])->name('company.store');
      Route::get('/company/edit/{id}',  [CompanyController::class,'companyEdit'])->name('company.edit');
      Route::post('/company/update',    [CompanyController::class,'companyUpdate'])->name('company.update');


      Route::get('bankaccounts',       [BankAccountController::class,'bankaccounts'])->name('bankaccounts');
      Route::post('bankaccount/store',       [BankAccountController::class,'bankaccountStore'])->name('bankaccount.store');
      Route::post('bankaccount/update',       [BankAccountController::class,'bankaccountUpdate'])->name('bankaccount.update');

      Route::get('sharecategories',       [ShareCategoryController::class,'sharecategories'])->name('sharecategories');
      Route::post('sharecategory/store',       [ShareCategoryController::class,'sharecategoryStore'])->name('sharecategory.store');
      Route::post('sharecategory/update',       [ShareCategoryController::class,'sharecategoryUpdate'])->name('sharecategory.update');

      Route::get('taxrates',       [TaxRateController::class,'taxrates'])->name('taxrates');
      Route::post('taxrate/store',       [TaxRateController::class,'taxrateStore'])->name('taxrate.store');
      Route::post('taxrate/update',       [TaxRateController::class,'taxrateUpdate'])->name('taxrate.update');

      Route::get('membertypes',       [MemberTypeController::class,'membertypes'])->name('membertypes');
      Route::post('membertype/store',       [MemberTypeController::class,'membertypeStore'])->name('membertype.store');
      Route::post('membertype/update',       [MemberTypeController::class,'membertypeUpdate'])->name('membertype.update');

      Route::get('paymentmodes',       [PaymentModeController::class,'paymentmodes'])->name('paymentmodes');
      Route::post('paymentmode/store',       [PaymentModeController::class,'paymentmodeStore'])->name('paymentmode.store');
      Route::post('paymentmode/update',       [PaymentModeController::class,'paymentmodeUpdate'])->name('paymentmode.update');

      Route::get('itemforsales',       [ItemForSaleController::class,'itemforsales'])->name('itemforsales');
      Route::post('itemforsale/store',       [ItemForSaleController::class,'itemforsaleStore'])->name('itemforsale.store');
      Route::post('itemforsale/update',       [ItemForSaleController::class,'itemforsaleUpdate'])->name('itemforsale.update');

      Route::get('userdocuments',       [UserDocumentTypeController::class,'userdocuments'])->name('userdocuments');
      Route::post('userdocument/store',       [UserDocumentTypeController::class,'userdocumentStore'])->name('userdocument.store');
      Route::post('userdocument/update',       [UserDocumentTypeController::class,'userdocumentUpdate'])->name('userdocument.update');

      Route::get('loandocuments',       [LoanDocumentTypeController::class,'loandocuments'])->name('loandocuments');
      Route::post('loandocument/store',       [LoanDocumentTypeController::class,'loandocumentStore'])->name('loandocument.store');
      Route::post('loandocument/update',       [LoanDocumentTypeController::class,'loandocumentUpdate'])->name('loandocument.update');

      Route::get('userexpenses',       [UserExpenseController::class,'userexpenses'])->name('userexpenses');
      Route::post('userexpense/store',       [UserExpenseController::class,'userexpenseStore'])->name('userexpense.store');
      Route::post('userexpense/update',       [UserExpenseController::class,'userexpenseUpdate'])->name('userexpense.update');

      Route::get('userincomes',       [UserIncomeController::class,'userincomes'])->name('userincomes');
      Route::post('userincome/store',       [UserIncomeController::class,'userincomeStore'])->name('userincome.store');
      Route::post('userincome/update',       [UserIncomeController::class,'userincomeUpdate'])->name('userincome.update');

      Route::get('collateraltypes',       [CollateralTypeController::class,'collateraltypes'])->name('collateraltypes');
      Route::post('collateraltype/store',       [CollateralTypeController::class,'collateraltypeStore'])->name('collateraltype.store');
      Route::post('collateraltype/update',       [CollateralTypeController::class,'collateraltypeUpdate'])->name('collateraltype.update');

      Route::get('approvalsettings',       [ApprovalSettingController::class,'approvalsettings'])->name('approvalsettings');
      Route::post('approvalsetting/store',       [ApprovalSettingController::class,'approvalsettingStore'])->name('approvalsetting.store');
      Route::post('approvalsetting/update',       [ApprovalSettingController::class,'approvalsettingUpdate'])->name('approvalsetting.update');

      Route::get('approvalpins',       [ApprovalPinController::class,'approvalpins'])->name('approvalpins');
      Route::post('approvalpin/store',       [ApprovalPinController::class,'approvalpinStore'])->name('approvalpin.store');
      Route::post('approvalpin/update',       [ApprovalPinController::class,'approvalpinUpdate'])->name('approvalpin.update');

      Route::get('/lenders',        [LenderController::class,'lenders'])->name('lenders');
      Route::get('/lender/create',   [LenderController::class,'lenderCreate'])->name('lender.create');
      Route::post('/lender/store',     [LenderController::class,'lenderStore'])->name('lender.store');
      Route::get('/lender/edit/{id}',  [LenderController::class,'lenderEdit'])->name('lender.edit');
      Route::post('/lender/update',    [LenderController::class,'lenderUpdate'])->name('lender.update');

      Route::get('paysliptypes',       [PayslipTypeController::class,'paysliptypes'])->name('paysliptypes');
      Route::post('paysliptype/store',       [PayslipTypeController::class,'paysliptypeStore'])->name('paysliptype.store');
      Route::post('paysliptype/update',       [PayslipTypeController::class,'paysliptypeUpdate'])->name('paysliptype.update');

      Route::get('allowanceoptions',       [AllowanceOptionController::class,'allowanceoptions'])->name('allowanceoptions');
      Route::post('allowanceoption/store',       [AllowanceOptionController::class,'allowanceoptionStore'])->name('allowanceoption.store');
      Route::post('allowanceoption/update',       [AllowanceOptionController::class,'allowanceoptionUpdate'])->name('allowanceoption.update');

       Route::get('deductionoptions',       [DeductionOptionController::class,'deductionoptions'])->name('deductionoptions');
      Route::post('deductionoption/store',       [DeductionOptionController::class,'deductionoptionStore'])->name('deductionoption.store');
      Route::post('deductionoption/update',       [DeductionOptionController::class,'deductionoptionUpdate'])->name('deductionoption.update');


      Route::get('/savingproducts',        [SavingProductController::class,'savingproducts'])->name('savingproducts');
      Route::get('/savingproduct/create',   [SavingProductController::class,'savingproductCreate'])->name('savingproduct.create');
      Route::post('/savingproduct/store',     [SavingProductController::class,'savingproductStore'])->name('savingproduct.store');
      Route::get('/savingproduct/edit/{id}',  [SavingProductController::class,'savingproductEdit'])->name('savingproduct.edit');
      Route::post('/savingproduct/update',    [SavingProductController::class,'savingproductUpdate'])->name('savingproduct.update');


      // Branches
      Route::get('/transactionchannels',        [TransactionChannelController::class,'transactionchannels'])->name('transactionchannels');
      Route::get('/transactionchannel/create',   [TransactionChannelController::class,'transactionchannelCreate'])->name('transactionchannel.create');
      Route::post('/transactionchannel/store',     [TransactionChannelController::class,'transactionchannelStore'])->name('transactionchannel.store');
      Route::get('/transactionchannel/edit/{id}',  [TransactionChannelController::class,'transactionchannelEdit'])->name('transactionchannel.edit');
      Route::post('/transactionchannel/update',    [TransactionChannelController::class,'transactionchannelUpdate'])->name('transactionchannel.update');

      Route::get('/socialfunds',        [SocialFundController::class,'socialfunds'])->name('socialfunds');
      Route::get('/socialfund/create',   [SocialFundController::class,'socialfundCreate'])->name('socialfund.create');
      Route::post('/socialfund/store',     [SocialFundController::class,'socialfundStore'])->name('socialfund.store');
      Route::get('/socialfund/edit/{id}',  [SocialFundController::class,'socialfundEdit'])->name('socialfund.edit');
      Route::post('/socialfund/update',    [SocialFundController::class,'socialfundUpdate'])->name('socialfund.update');

      Route::get('/memberaccount',        [MemberAccountController::class,'memberaccounts'])->name('memberaccounts');
      Route::get('/memberaccount/create',   [MemberAccountController::class,'memberaccountCreate'])->name('memberaccount.create');
      Route::post('/memberaccount/store',     [MemberAccountController::class,'memberaccountStore'])->name('memberaccount.store');
      Route::get('/memberaccount/edit/{id}',  [MemberAccountController::class,'memberaccountEdit'])->name('memberaccount.edit');
      Route::post('/memberaccount/update',    [MemberAccountController::class,'memberaccountUpdate'])->name('memberaccount.update');

      Route::get('/shareaccounts',        [ShareAccountController::class,'shareaccounts'])->name('shareaccounts');
      Route::get('/shareaccount/create',   [ShareAccountController::class,'shareaccountCreate'])->name('shareaccount.create');
      Route::post('/shareaccount/store',     [ShareAccountController::class,'shareaccountStore'])->name('shareaccount.store');
      Route::get('/shareaccount/edit/{id}',  [ShareAccountController::class,'shareaccountEdit'])->name('shareaccount.edit');
      Route::post('/shareaccount/update',    [ShareAccountController::class,'shareaccountUpdate'])->name('shareaccount.update');


       Route::get('/savingfees',        [SavingFeeController::class,'savingfees'])->name('savingfees');
      Route::get('/savingfee/create',   [SavingFeeController::class,'savingfeeCreate'])->name('savingfee.create');
      Route::post('/savingfee/store',     [SavingFeeController::class,'savingfeeStore'])->name('savingfee.store');
      Route::get('/savingfee/edit/{id}',  [SavingFeeController::class,'savingfeeEdit'])->name('savingfee.edit');
      Route::post('/savingfee/update',    [SavingFeeController::class,'savingfeeUpdate'])->name('savingfee.update');

      Route::get('/loanfees',        [LoanFeeController::class,'loanfees'])->name('loanfees');
      Route::get('/loanfee/create',   [LoanFeeController::class,'loanfeeCreate'])->name('loanfee.create');
      Route::post('/loanfee/store',     [LoanFeeController::class,'loanfeeStore'])->name('loanfee.store');
      Route::get('/loanfee/edit/{id}',  [LoanFeeController::class,'loanfeeEdit'])->name('loanfee.edit');
      Route::post('/loanfee/update',    [LoanFeeController::class,'loanfeeUpdate'])->name('loanfee.update');

       Route::get('/loanproducts',        [LoanProductController::class,'loanproducts'])->name('loanproducts');
      Route::get('/loanproduct/create',   [LoanProductController::class,'loanproductCreate'])->name('loanproduct.create');
      Route::post('/loanproduct/store',     [LoanProductController::class,'loanproductStore'])->name('loanproduct.store');
      Route::get('/loanproduct/edit/{id}',  [LoanProductController::class,'loanproductEdit'])->name('loanproduct.edit');
      Route::post('/loanproduct/update',    [LoanProductController::class,'loanproductUpdate'])->name('loanproduct.update');

      Route::get('/borrowproducts',        [BorrowProductController::class,'borrowproducts'])->name('borrowproducts');
      Route::get('/borrowproduct/create',   [BorrowProductController::class,'borrowproductCreate'])->name('borrowproduct.create');
      Route::post('/borrowproduct/store',     [BorrowProductController::class,'borrowproductStore'])->name('borrowproduct.store');
      Route::get('/borrowproduct/edit/{id}',  [BorrowProductController::class,'borrowproductEdit'])->name('borrowproduct.edit');
      Route::post('/borrowproduct/update',    [BorrowProductController::class,'borrowproductUpdate'])->name('borrowproduct.update');


      Route::get('/journalaccounts',        [JournalAccountController::class,'journalaccounts'])->name('journalaccounts');
      Route::get('/journalaccount/create',   [JournalAccountController::class,'journalaccountCreate'])->name('journalaccount.create');
      Route::post('/journalaccount/store',     [JournalAccountController::class,'journalaccountStore'])->name('journalaccount.store');
      Route::get('/journalaccount/edit/{id}',  [JournalAccountController::class,'journalaccountEdit'])->name('journalaccount.edit');
      Route::post('/journalaccount/update',    [JournalAccountController::class,'journalaccountUpdate'])->name('journalaccount.update');

      Route::get('/paymentmethods',        [PaymentmethodController::class,'paymentmethods'])->name('paymentmethods');
      Route::get('/paymentmethod/create',   [PaymentmethodController::class,'paymentmethodCreate'])->name('paymentmethod.create');
      Route::post('/paymentmethod/store',     [PaymentmethodController::class,'paymentmethodStore'])->name('paymentmethod.store');
      Route::get('/paymentmethod/edit/{id}',  [PaymentmethodController::class,'paymentmethodEdit'])->name('paymentmethod.edit');
      Route::post('/paymentmethod/update',    [PaymentmethodController::class,'paymentmethodUpdate'])->name('paymentmethod.update');

      Route::get('/paymentaccounts',        [PaymentAccountController::class,'paymentaccounts'])->name('paymentaccounts');
      Route::get('/paymentaccount/create',   [PaymentAccountController::class,'paymentaccountCreate'])->name('paymentaccount.create');
      Route::post('/paymentaccount/store',     [PaymentAccountController::class,'paymentaccountStore'])->name('paymentaccount.store');
      Route::get('/paymentaccount/edit/{id}',  [PaymentAccountController::class,'paymentaccountEdit'])->name('paymentaccount.edit');
      Route::post('/paymentaccount/update',    [PaymentAccountController::class,'paymentaccountUpdate'])->name('paymentaccount.update');

      Route::get('/organizations',        [OrganizationController::class,'organizations'])->name('organizations');
      Route::get('/organization/create',   [OrganizationController::class,'organizationCreate'])->name('organization.create');
      Route::post('/organization/store',     [OrganizationController::class,'organizationStore'])->name('organization.store');
      Route::get('/organization/edit/{id}',  [OrganizationController::class,'organizationEdit'])->name('organization.edit');
      Route::post('/organization/update',    [OrganizationController::class,'organizationUpdate'])->name('organization.update');

      Route::get('/payrollsettings',        [PayrollSettingController::class,'payrollsettings'])->name('payrollsettings');
      Route::get('/payrollsetting/create',   [PayrollSettingController::class,'payrollsettingCreate'])->name('payrollsetting.create');
      Route::post('/payrollsetting/store',     [PayrollSettingController::class,'payrollsettingStore'])->name('payrollsetting.store');
      Route::get('/payrollsetting/edit/{id}',  [PayrollSettingController::class,'payrollsettingEdit'])->name('payrollsetting.edit');
      Route::post('/payrollsetting/update',    [PayrollSettingController::class,'payrollsettingUpdate'])->name('payrollsetting.update');

      Route::get('/myloans',           [LoanController::class,'myloans'])->name('myloans');

      Route::get('/loans',           [LoanController::class,'loans'])->name('loans');
      Route::get('/memberloans',     [LoanController::class,'memberLoans'])->name('memberloans');
      Route::get('/grouploans',      [LoanController::class,'groupLoans'])->name('grouploans');
      Route::get('/loan/create',     [LoanController::class,'loanCreate'])->name('loan.create');
      Route::post('/loan/store',          [LoanController::class,'loanStore'])->name('loan.store');
      Route::get('/loan/edit/{id}',       [LoanController::class,'loanEdit'])->name('loan.edit');
      Route::post('/loan/update',         [LoanController::class,'loanUpdate'])->name('loan.update');
      Route::get('/loan/dashboard/{id}', [LoanController::class,'loanDashboard'])->name('loan.dashboard');

      Route::post('/loan/review/update',    [LoanController::class,'loanReviewUpdate'])->name('loan.review.update');
      Route::post('/loan/review/store',    [LoanController::class,'loanReviewStore'])->name('loan.review.store');
      Route::get('/loan/review/pdf/{id}', [LoanController::class,'loanReviewPdf'])->name('loan.reviewpdf');
      Route::get('/loan/print/pdf/{id}', [LoanController::class,'loanPrintPdf'])->name('loan.printpdf');
      Route::get('/loan/getstaffs/{id}',  [LoanController::class,'loanStaff'])->name('loan.staffs');
      Route::post('/loan/staff/assign',   [LoanController::class,'staffAssign'])->name('loan.staff.assign');
      Route::post('/loan/get',[LoanController::class,'loanRepaymentSchedule'])->name('loan.repayment');
      Route::get('/loan/preview/{id}', [LoanController::class,'loanPreview'])->name('loan.preview');
      Route::get('/loan/approval/{id}', [LoanController::class,'loanApproval'])->name('loan.approval');
      Route::post('/loan/approval/store',    [LoanController::class,'loanApprovalStore'])->name('loan.approval.store');
      Route::get('/loan/disburse/{id}',       [LoanController::class,'loanDisburse'])->name('loan.disburse');
      Route::post('/loan/disburse/store',       [LoanController::class,'loanDisburseStore'])->name('loan.disburse.store');
      Route::get('/loan/review/{id}',       [LoanController::class,'loanReviewEdit'])->name('loan.review');
      Route::post('/loan/fees/calculate',    [LoanController::class,'loanFeesCalculate'])->name('loan.feescalculate');
            Route::post('/loan/collateral/store',   [LoanController::class,'collateralStore'])->name('loan.collateral.store');
       Route::post('/loan/collateral/update', [LoanController::class,'collateralUpdate'])->name('loan.collateral.update');
       Route::post('loan/collateral/delete',   [LoanController::class,'collateralDelete'])->name('loan.collateral.delete');

       Route::post('/loan/guarantor/store',   [LoanController::class,'guarantorStore'])->name('loan.guarantor.store');
       Route::post('/loan/guarantor/update', [LoanController::class,'guarantorUpdate'])->name('loan.guarantor.update');
       Route::post('loan/guarantor/delete',   [LoanController::class,'guarantorDelete'])->name('loan.guarantor.delete');

       Route::post('/loan/expense/store',   [LoanController::class,'expenseStore'])->name('loan.expense.store');
       Route::post('/loan/expense/update', [LoanController::class,'expenseUpdate'])->name('loan.expense.update');
       Route::post('/loan/expense/delete', [LoanController::class,'expenseDelete'])->name('loan.expense.delete');

       Route::post('/loan/document/store',   [LoanController::class,'documentStore'])->name('loan.document.store');
       Route::post('/loan/document/update', [LoanController::class,'documentUpdate'])->name('loan.document.update');
       Route::post('/loan/document/delete', [LoanController::class,'documentDelete'])->name('loan.document.delete');

       Route::post('/loan/repayment/store',   [LoanController::class,'repaymentStore'])->name('loan.repayment.store');
       Route::post('/loan/repayment/update', [LoanController::class,'repaymentUpdate'])->name('loan.repayment.update');

       Route::get('/dbbackups',           [DbBackupController::class,'dbbackups'])->name('dbbackups');
       Route::post('/dbbackup/generate',           [DbBackupController::class,'dbbackupGenerate'])->name('dbbackup.generate');

     Route::get('/roles',   [RoleController::class,'roles'])->name('roles');
      Route::get('/role/create',   [RoleController::class,'roleCreate'])->name('role.create');
      Route::post('/role/store',   [RoleController::class,'roleStore'])->name('role.store');
      Route::get('/roles/{id}', [RoleController::class,'roleEdit'])->name('role.edit');
      Route::delete('/roles/{id}', [RoleController::class,'roleDelete'])->name('role.delete');
      Route::put('/roles/{id}/update', [RoleController::class,'roleUpdate'])->name('role.update');

 });

});
