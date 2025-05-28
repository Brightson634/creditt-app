<?php

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Asset;
use App\Models\Group;

use App\Models\Branch;

use App\Models\Lender;
use App\Models\Member;

use App\Models\Company;
use App\Models\Tenants;
use App\Utilities\Util;

use App\Models\Supplier;
use App\Models\GroupLoan;
use App\Utility\Currency;
use App\Models\Investment;
use App\Models\MemberLoan;
use App\Models\Permission;
use App\Models\SavingWeek;
use App\Models\SavingYear;
use App\Models\StaffMember;

use Illuminate\Support\Str;
use App\Models\JournalEntry;

use App\Models\ShareAccount;
use App\Models\AnalyticsPage;
use App\Models\MemberAccount;
use App\Models\SavingProduct;
use App\Utils\AccountingUtil;
use PHPMailer\PHPMailer\SMTP;
use App\Models\ChartOfAccount;
use App\Models\ExpenseCategory;
use App\Models\AnalyticsVisitor;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Entities\AccountingAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Entities\AccountingAccountType;
use Illuminate\Support\Facades\Session;
use App\Entities\AccountingAccTransMapping;
use App\Entities\AccountingAccountsTransaction;

function webmaster()
{
    return auth()->guard('webmaster')->user();
}

function member()
{
    return auth()->guard('member')->user();
}

function menu($route)
{
    if (is_array($route)) {
        foreach ($route as $value) {
            if (request()->routeIs($value)) {
                return 'active';
            }
        }
    } elseif (request()->routeIs($route)) {
        return 'active';
    }
}

function fullDate($date, $format = 'l d M, Y')
{
    return Carbon::parse($date)->format($format);
}

function dateFormat($date, $format = 'd M, Y')
{
    if($date === null)
    {
        return 'Not Yet';
    }
    return Carbon::parse($date)->format($format);
}

function formatDate($date, $format = 'd M, Y')
{
    return Carbon::parse($date)->format($format);
}

function showDateTime($date, $format = 'd M, Y')
{
    return Carbon::parse($date)->format($format);
}

function shortendDateFormat($date)
{
    if($date === null)
    {
        return 'N/A';
    }
    return Carbon::parse($date)->format('M d, Y');
}

function formattedDateWithoutSeconds($date)
{
    $formated_date = Carbon::parse($date);
    return $formated_date->format('Y-m-d H:i');
}

function usernameGenerate($email)
{
    $explodeEmail = explode('@', $email);
    $username = $explodeEmail[0];
    return $username;
}



if (!function_exists('slug_create')) {
    function slug_create($val)
    {
        $slug = Str::slug($val);
        return $slug;
    }
}

function slugCreate($val)
{
    $slug = Str::slug($val);
    return $slug;
}

function generateTxnNumber()
{
    $prefix_code = 'DQS';
    $latestId = Transaction::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $currentDate = Carbon::now();
    $year = $currentDate->format('Y');
    $month = $currentDate->format('m');
    $date = $currentDate->format('d');
    $accountNumber = $prefix_code . $year . $month . $date . $nextNumber;

    return $accountNumber;
}

function generateLoanNumber()
{
    $tenantId = request()->attributes->get('business_id');
    $setting = Tenants::find($tenantId);
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = $setting->loan_prefix !== null ? $setting->loan_prefix : 'MBR';
    $latestId = Loan::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $loanNumber = $prefix_code . $randomString . $nextNumber;

    return $loanNumber;
}

function generateGroupLoanNumber()
{
    $tenantId = request()->attributes->get('business_id');
    $setting = Tenants::find($tenantId);
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'GRL';
    $prefix_code = $setting->loan_prefix !== null ? $setting->loan_prefix . 'GRL' : 'GRL';
    $latestId = GroupLoan::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $loanNumber = $prefix_code . $randomString . $nextNumber;
    return $loanNumber;
}

function generateJournalEntryNumber()
{
    $prefix_code = 'JUR';
    $latestId = JournalEntry::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $journalEntry = $prefix_code . $nextNumber;
    return $journalEntry;
}



function generateMemberLoanNumber()
{
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'GRL';
    $latestId = MemberLoan::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $loanNumber = $prefix_code . $randomString . $nextNumber;
    return $loanNumber;
}

function generateAccountNumber()
{
    $tenantId = request()->attributes->get('business_id');
    $setting = Tenants::find($tenantId);
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = $setting->member_account_prefix !== null ? $setting->member_account_prefix : 'GRL';
    $latestId = MemberAccount::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $accountNumber = $prefix_code . $randomString . $nextNumber;

    return $accountNumber;
}

function generateShareAccountNumber()
{
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'GRL';
    $latestId = ShareAccount::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $loanNumber = $prefix_code . $randomString . $nextNumber;

    return $loanNumber;
}


function generateMemberNumber()
{
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'MBR';
    $latestId = Member::latest()->value('id');
    // $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';

    $memberNumber = $prefix_code . $randomString . $latestId + 1;

    return $memberNumber;
}

// function showAmount($amount, $decimal = 2, $separate = true)
// {
//     $tenantId = request()->attributes->get('business_id');
//     $gs = Tenants::find($tenantId);
//     $currency= Currency::find($gs->currency_symbol);
//     $currencySymbol = $currency?->code ?? 'UGX';
//     $separator = '';
//     if ($separate) {
//         $separator = ',';
//     }
//     $currencySymbol = '<small class="mr-1" style="font-size:14px"> ' .$currencySymbol. '</small>';
//     $printAmount = $currencySymbol . number_format($amount, $decimal, '.', $separator);
//     $exp = explode('.', $printAmount);
//     if ($exp[1] * 1 == 0) {
//         $printAmount = $exp[0];
//     }

//     return $printAmount;
// }
function showAmount($amount, $decimal = 2, $separate = true, $shorten = true)
{
    $tenantId = request()->attributes->get('business_id');
    $gs = Tenants::find($tenantId);
    $currency = Currency::find($gs->currency_symbol);
    $currencySymbol = $currency?->code ?? 'UGX';
    $separator = $separate ? ',' : '';

    $currencySymbol = '<small class="mr-1" style="font-size:14px"> ' . $currencySymbol . '</small>';

    if ($shorten && abs($amount) >= 1000) {
        $formattedAmount = formatNumberShort($amount, $decimal);
    } else {
        $formattedAmount = number_format($amount, $decimal, '.', $separator);
    }

    if (!$shorten) {
        $exp = explode('.', $formattedAmount);
        if (isset($exp[1]) && intval($exp[1]) === 0) {
            $formattedAmount = $exp[0];
        }
    }

    return $currencySymbol . '<span style="font-size:18px;">'.$formattedAmount.'</span>';
}

function formatNumberShort($number, $precision = 1) {
    if ($number < 1000) {
        return $number;
    }

    $units = ['K' => 1000, 'M' => 1000000, 'B' => 1000000000, 'T' => 1000000000000];

    foreach ($units as $suffix => $value) {
        if ($number < ($value * 1000)) {
            return round($number / $value, $precision) . $suffix;
        }
    }

    return $number; // Fallback
}



if (!function_exists('formattedAmount')) {
    function formattedAmount($amount, $decimal = 2, $separate = true)
    {
        $separator = '';
        if ($separate) {
            $separator = ',';
        }
        $printAmount = number_format($amount, $decimal, '.', $separator);
        return $printAmount;
    }
}

if (!function_exists('generateMemberUniqueID')) {

    /**
     * Generate Unique member Id
     *
     * @param [type] $sys_prefix
     * @param [type] $gender
     * @param [type] $dob
     * @param [type] $group_name
     * @return string
     */
    function generateMemberUniqueID($sys_prefix ,$gender,$dob,$group_name): string
    {
        $latestId = Member::max('id') + 1;

        $prefix = $sys_prefix ?? 'MBR';

        if ($gender !== null && $dob !== null) {
            $genderInitial = strtoupper(substr($gender, 0, 1));
            $uniqueId = "{$prefix}{$dob}{$genderInitial}{$latestId}";
        } else {
            $today = Carbon::today()->format('Ymd');
            $groupCode = $group_name ? strtoupper(substr($group_name, 0, 3)) : 'GRP';
            $uniqueId = "{$prefix}{$today}{$groupCode}{$latestId}";
        }

        return $uniqueId;
    }
}

if (!function_exists('AllChartsOfAccounts')) {
    function AllChartsOfAccounts()
    {
        $business_id = request()->attributes->get('business_id');
        $accounts = AccountingAccount::forDropdown($business_id, true);
        // return new JsonResponse($accounts);
        // return $accounts;
        $translations = [
            "accounting::lang.accounts_payable" => "Accounts Payable",
            "accounting::lang.accounts_receivable" => "Accounts Receivable (AR)",
            "accounting::lang.credit_card" => "Credit Card",
            "accounting::lang.current_assets" => "Current Assets",
            "accounting::lang.cash_and_cash_equivalents" => "Cash and Cash Equivalents",
            "accounting::lang.fixed_assets" => "Fixed Assets",
            "accounting::lang.non_current_assets" => "Non Current Assets",
            "accounting::lang.cost_of_sale" => "Cost of Sale",
            "accounting::lang.expenses" => "Expenses",
            "accounting::lang.other_expense" => "Other Expense",
            "accounting::lang.income" => "Income",
            "accounting::lang.other_income" => "Other Income",
            "accounting::lang.owners_equity" => "Owner Equity",
            "accounting::lang.current_liabilities" => "Current Liabilities",
            "accounting::lang.non_current_liabilities" => "Non-Current Liabilities",
        ];

        $accounts_array = [];
        foreach ($accounts as $account) {
            $translatedText = $translations[$account->sub_type] ?? $account->sub_type;
            $accounts_array[] = [
                'id' => $account->id,
                'name' => $account->name,
                'primaryType' => $account->account_primary_type,
                'subType' => $translatedText,
                'currency' => $account->account_currency
            ];
        }

        return $accounts_array;
    }
}

if (!function_exists('getParentAccounts')) {
    function getParentAccounts()
    {
        $business_id = request()->attributes->get('business_id');

        $account_sub_types = AccountingAccountType::where('account_type', 'sub_type')
            ->where(function ($q) use ($business_id) {
                $q->whereNull('business_id')
                    ->orWhere('business_id', $business_id);
            })
            ->get();
        return $account_sub_types;
    }
}
//produce comma separated value
if (!function_exists('generateComaSeparatedValue')) {
    function generateComaSeparatedValue($number)
    {
        return number_format($number, 2, '.', ',');
    }
}
//member acc balance
if (!function_exists('checkMemberAccBalance')) {
    function checkMemberAccBalance($account_id, $accounting_accounts_alias = 'accounting_accounts', $accounting_account_transaction_alias = 'AAT')
    {
        // Make sure the account ID is provided
        if (empty($account_id)) {
            return 0; // Return zero if no account_id is given
        }

        // SQL query to sum the balance for a particular account
        return "SELECT SUM(IF(
        ($accounting_accounts_alias.account_primary_type='asset' AND $accounting_account_transaction_alias.type='debit')
        OR ($accounting_accounts_alias.account_primary_type='expense' AND $accounting_account_transaction_alias.type='debit')
        OR ($accounting_accounts_alias.account_primary_type='income' AND $accounting_account_transaction_alias.type='credit')
        OR ($accounting_accounts_alias.account_primary_type='equity' AND $accounting_account_transaction_alias.type='credit')
        OR ($accounting_accounts_alias.account_primary_type='liability' AND $accounting_account_transaction_alias.type='credit'), 
        amount, amount)) AS balance
        FROM $accounting_account_transaction_alias
        JOIN $accounting_accounts_alias 
        ON $accounting_accounts_alias.id = $accounting_account_transaction_alias.account_id
        WHERE $accounting_account_transaction_alias.account_id = $account_id";
    }
}

//check if loan has been disbursed
function loanAlreadyDisbursed($loan_id)
{
    $loan = Loan::find($loan_id);
    if ($loan->status == 5) {
        return true;
    } else {
        return false;
    }
}

//get loan process collateral methods
if (!function_exists('getLoanCollateralMethods')) {
    function getLoanCollateralMethods()
    {
         $tenantId = request()->attributes->get('business_id');
         $setting = Tenants::find($tenantId);
        $collateralMethods = explode(',', $setting->collateral_methods);
        return $collateralMethods;
    }
}


function showAmountPdf($amount, $decimal = 2, $separate = true)
{
    $tenantId = request()->attributes->get('business_id');
    $gs = Tenants::find($tenantId);
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $currencySymbol = '<small style="font-size:8px; margin-right: 2px"> ' . $gs->currency_symbol . '</small>';
    $printAmount = $currencySymbol . number_format($amount, $decimal, '.', $separator);
    $exp = explode('.', $printAmount);
    if ($exp[1] * 1 == 0) {
        $printAmount = $exp[0];
    }

    return $printAmount;
}


function getAmount($amount, $decimal = 2, $separate = true)
{
    $tenantId = request()->attributes->get('business_id');
    $gs = Tenants::find($tenantId);
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $printAmount = $gs->currency_symbol . number_format($amount, $decimal, '.', $separator);
    $exp = explode('.', $printAmount);
    if ($exp[1] * 1 == 0) {
        $printAmount = $exp[0];
    }

    return $printAmount;
}


function sendSmtpMail($receiver_email, $receiver_name, $subject, $message)
{
    $tenantId = request()->attributes->get('business_id');
    $setting = Tenants::find($tenantId);
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $setting->smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $setting->smtp_user;
        $mail->Password   = $setting->smtp_password;
        if ($setting->mail_encryption == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        } else {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port       = $setting->smtp_port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom($setting->email_from, $setting->title);
        $mail->addAddress($receiver_email, $receiver_name);
        $mail->addReplyTo($setting->email_from, $setting->title);
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();
    } catch (Exception $e) {
        throw new Exception($e);
    }
}

function vistorInformation($ip, $url)
{
    $load_time = round((microtime(true) - LARAVEL_START), 8);
    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "unknown";
    $browser = getBrowser();
    $platform = getOS();
    $device = getDevice();

    $savedVisitor = AnalyticsVisitor::where('ip_address', '=', $ip)->where('date', '=', date('Y-m-d'))->first();
    if (empty($savedVisitor) || @$savedVisitor->country == "unknown") {

        $info = json_decode(json_encode(getIpInfomation()), true);
        $city = isset($info['city']) && is_array($info['city']) ? implode(',', $info['city']) : '';
        $region = isset($info['area']) && is_array($info['area']) ? implode(',', $info['area']) : '';
        $time = isset($info['time']) && is_array($info['time']) ? implode(',', $info['time']) : '';
        $country_code = isset($info['code']) && is_array($info['code']) ? implode(',', $info['code']) : '';
        $country = isset($info['country']) && is_array($info['country']) ? implode(',', $info['country']) : '';
        $location = $city . ' - ' . $region . ' - ' . $country . ' - ' . $country_code . ' - ' . $time;

        $visitor = new AnalyticsVisitor;
        $visitor->ip_address =  $ip;
        $visitor->city =  $city;
        $visitor->country_code =  $country_code;
        $visitor->country =  $country;
        $visitor->region =  $region;
        $visitor->location =  $location;
        $visitor->browser = $browser;
        $visitor->platform = $platform;
        $visitor->device = $device;
        $visitor->referrer = $referrer;
        $visitor->date = date('Y-m-d');
        $visitor->time = date('H:i:s');
        $visitor->save();

        $page = new AnalyticsPage;
        $page->visitor_id = $visitor->id;
        $page->ip = $ip;
        $page->title = "unknown";
        $page->url = $url;
        $page->load_time = $load_time;
        $page->date = date('Y-m-d');
        $page->time = date('H:i:s');
        $page->save();
    } else {
        $savedPage = AnalyticsPage::where('visitor_id', '=', $savedVisitor->id)->where('ip', '=', $ip)->where('date', '=', date('Y-m-d'))->where('url', '=', $url)->first();
        if (empty($savedPage)) {
            $page = new AnalyticsPage;
            $page->visitor_id = $savedVisitor->id;
            $page->ip = $ip;
            $page->title = "unknown";
            $page->url = $url;
            $page->load_time = $load_time;
            $page->date = date('Y-m-d');
            $page->time = date('H:i:s');
            $page->save();
        }
    }
}

function getIpInfomation()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
    }

    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}

function getBrowser()
{
    preg_match('/Trident\/(.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if ($matches) {
        $version = intval($matches[1]) + 4;
        return 'Internet Explorer ' . ($version < 11 ? $version : $version);
    }
    preg_match('/MSIE (.*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
    if ($matches) {
        return 'Internet Explorer ' . intval($matches[1]);
    }
    foreach (array('Firefox', 'OPR', 'Chrome', 'Safari') as $browser) {
        preg_match('/' . $browser . '/', $_SERVER['HTTP_USER_AGENT'], $matches);
        if ($matches) {
            return str_replace(
                'OPR',
                'Opera',
                $browser
            );
        }
    }
}

function getOS()
{
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    return $os_platform;
}

function getDevice()
{
    $tablet_browser = 0;
    $mobile_browser = 0;
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $userAgent)) {
        $tablet_browser++;
    }

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $userAgent)) {
        $mobile_browser++;
    }

    if ((strpos(strtolower(Request::header('Accept')), 'application/vnd.wap.xhtml+xml') > 0) ||
        (Request::has('HTTP_X_WAP_PROFILE') || Request::has('HTTP_PROFILE'))
    ) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($userAgent, 0, 4));
    $mobile_agents = array(
        'w3c',
        'acs-',
        'alav',
        'alca',
        'amoi',
        'audi',
        'avan',
        'benq',
        'bird',
        'blac',
        'blaz',
        'brew',
        'cell',
        'cldc',
        'cmd-',
        'dang',
        'doco',
        'eric',
        'hipt',
        'inno',
        'ipaq',
        'java',
        'jigs',
        'kddi',
        'keji',
        'leno',
        'lg-c',
        'lg-d',
        'lg-g',
        'lge-',
        'maui',
        'maxo',
        'midp',
        'mits',
        'mmef',
        'mobi',
        'mot-',
        'moto',
        'mwbp',
        'nec-',
        'newt',
        'noki',
        'palm',
        'pana',
        'pant',
        'phil',
        'play',
        'port',
        'prox',
        'qwap',
        'sage',
        'sams',
        'sany',
        'sch-',
        'sec-',
        'send',
        'seri',
        'sgh-',
        'shar',
        'sie-',
        'siem',
        'smal',
        'smar',
        'sony',
        'sph-',
        'symb',
        't-mo',
        'teli',
        'tim-',
        'tosh',
        'tsm-',
        'upg1',
        'upsi',
        'vk-v',
        'voda',
        'wap-',
        'wapa',
        'wapi',
        'wapp',
        'wapr',
        'webc',
        'winw',
        'winw',
        'xda',
        'xda-'
    );

    if (in_array($mobile_ua, $mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($userAgent), 'opera mini') > 0) {
        $mobile_browser++;
        // Check for tables on opera mini alternative headers
        $stock_ua = strtolower(Request::header('HTTP_X_OPERAMINI_PHONE_UA', '') ?: Request::header('HTTP_DEVICE_STOCK_UA', ''));

        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
            $tablet_browser++;
        }
    }

    if ($tablet_browser > 0) {
        // do something for tablet devices
        return 'Tablet';
    } elseif ($mobile_browser > 0) {
        // do something for mobile devices
        return 'Mobile';
    } else {
        // do something for everything else
        return 'Computer';
    }
}



function generateBranchNumber()
{
    $prefix_code = 'BR';
    $latestId = Branch::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateStaffNumber()
{
    $prefix_code = 'ST';
    $latestId = StaffMember::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateAssetNumber()
{
    $prefix_code = 'AST';
    $latestId = Asset::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}
function generateInvestmentNumber()
{
    $prefix_code = 'IVT';
    $latestId = Investment::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateSupplierNumber()
{
    $prefix_code = 'SUP';
    $latestId = Supplier::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateGroupNumber()
{
    $prefix_code = 'GRP';
    $latestId = Group::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateCompanyNumber()
{
    $prefix_code = 'CPY';
    $latestId = Company::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateLenderNumber()
{
    $prefix_code = 'LDR';
    $latestId = Lender::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateSavingProductNumber()
{
    $prefix_code = 'LDR';
    $latestId = SavingProduct::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

if (!function_exists('format_number')) {
    /**
     * Format a number with commas.
     *
     * @param float|int $number
     * @param int $decimals
     * @return string
     */
    function format_number($number, $decimals = 0)
    {
        return number_format($number, $decimals, '.', ',');
    }
}
/**
 * Gets the total available balance of a given account
 *
 * @param integer $account_id
 * @param integer $business_id
 * 
 */
function getAccountBalance($account_id, $business_id)
{
    // Generate the balance formula
    $accountingUtil = new AccountingUtil();
    $balance_formula = $accountingUtil->balanceFormula('AA');

    // Build the query for the specific account
    $query = AccountingAccount::where('business_id', $business_id)
        ->where('id', $account_id)  // Filter by the specific account ID
        ->select([
            DB::raw("(SELECT $balance_formula
                FROM accounting_accounts_transactions AS AAT
                JOIN accounting_accounts AS AA ON AAT.accounting_account_id = AA.id
                WHERE AAT.accounting_account_id = accounting_accounts.id) AS balance"),
            'accounting_accounts.*'
        ]);

    // Retrieve the account and its balance
    $account = $query->first();
    return $account ? $account->balance : 0;
}

// function insertAccountTransaction($account_id, $type, $amount, $description,$transDate)
// {
//     $business_id = request()->attributes->get('business_id');
//     $accountingUtil =new AccountingUtil();
//     $account = AccountingAccount::where('id', $account_id)->first();
//     $transaction = new AccountTransaction();
//     $transaction->account_id = $account_id;
//     $transaction->type = $type;
//     $transaction->previous_amount = getAccountBalance($account_id,$business_id);
//     $transaction->amount = $amount;
//     $transaction->current_amount = getAccountBalance($account_id,$business_id)+ $amount;
//     $transaction->description = $description;
//     $transaction->date = date('Y-m-d');
//     $transaction->save();

//     $data = [
//         'amount' => $accountingUtil->num_uf($amount),
//         'accounting_account_id' => $account->id,
//         'created_by' => auth()->user()->id,
//         'operation_date' =>$transDate,
//     ];

//     // $data['type'] = in_array($input['account_primary_type'], ['asset', 'expenses']) ? 'debit' : 'credit';
//     $data['type'] ='credit';
//     $data['sub_type'] = 'deposit';
//     AccountingAccountsTransaction::createTransaction($data);

//     // $account->opening_balance -= $amount;
//     // $account->save();
// }

/**
 * Inserts records in the charts of account
 *
 * @param [type] $account_id
 * @param [type] $type
 * @param [type] $amount
 * @param [type] $description
 * @param [type] $transDate
 * @param [type] $operation_id
 * @return mixed
 */
function insertAccountTransaction($account_id, $type, $amount, $description, $transDate, $operation_id)
{
    $business_id = request()->attributes->get('business_id');
    $accountingUtil = new AccountingUtil();
    $util = new Util();

    $account = AccountingAccount::where('id', $account_id)->first();
    // Fetch previous balance once
    $previousBalance = getAccountBalance($account_id, $business_id);

    // Create the account transaction
    $transaction = new AccountTransaction();
    $transaction->account_id = memberAccountId($account_id);
    $transaction->type = $type === 'deposit' ? 'credit' : 'debit';
    $transaction->operation = $type === 'deposit' ? 'deposit' : 'withdraw';
    $transaction->previous_amount = $previousBalance;
    if ($type == 'deposit') {
        $transaction->deposit_id = $operation_id;
    } else {
        $transaction->withdraw_id = $operation_id;
    }
    $transaction->amount = $amount;

    // Update current balance based on transaction type
    $transaction->current_amount = $type === 'deposit' ? $previousBalance + $amount : $previousBalance - $amount;
    $transaction->description = $description;
    $transaction->date = $transDate;
    $transaction->save();



    // $ref_count = $util->setAndGetReferenceCount('accounting_deposit');
    //  // Generate reference number
    //  $ref_no = $util->generateReferenceNumber('accounting_deposit', $ref_count, $business_id, $prefix='');

    // $acc_trans_mapping = new AccountingAccTransMapping();
    // $acc_trans_mapping->business_id = $business_id;
    // $acc_trans_mapping->ref_no = $ref_no;
    // $acc_trans_mapping->note = $description;
    // $acc_trans_mapping->type = $type;
    // $acc_trans_mapping->created_by = auth()->user()->id;
    // $acc_trans_mapping->operation_date = $transDate;
    // $acc_trans_mapping->save();

    // Prepare data for accounting transactions
    $data = [

        // 'amount' => $type === 'withdraw' ? ($accountingUtil->num_uf($amount)) : $accountingUtil->num_uf($amount),
        'amount' => $accountingUtil->num_uf($amount),
        'accounting_account_id' => $account_id,
        'created_by' => auth()->user()->id,
        'operation_date' => $transDate,
        'type' => $type === 'deposit' ? 'credit' : 'debit',
        'sub_type' => $type,
    ];

    if ($type == 'deposit') {
        $data['deposit_id'] = $operation_id;
    } else {
        $data['withdraw_id'] = $operation_id;
    }

    // Create accounting transaction
    // AccountingAccountsTransaction::createTransaction($data);
    AccountingAccountsTransaction::create($data);

    // Update account balance (if needed)
    // if ($type === 'withdraw') {
    //     $account->opening_balance -= $amount;
    // } else {
    //     $account->opening_balance += $amount;
    // }
    // $account->save();
}
/**
 * Updates transactions
 *
 * @param [type] $account_id
 * @param [type] $type
 * @param [type] $amount
 * @param [type] $description
 * @param [type] $transDate
 * @param [type] $operation_id
 * @return mixed
 */
function insertUpdateAccountTransaction($account_id, $type, $amount, $description, $transDate, $operation_id)
{
    $business_id = request()->attributes->get('business_id');
    $accountingUtil = new AccountingUtil();
    $util = new Util();

    // Fetch the account and previous balance
    $account = AccountingAccount::where('id', $account_id)->first();
    $previousBalance = getAccountBalance($account_id, $business_id);

    // Fetch existing transaction for update or create a new one
    if ($type == 'deposit') {
        $transaction = AccountTransaction::where('deposit_id', $operation_id)->firstOrNew();
    } else {
        $transaction = AccountTransaction::where('withdraw_id', $operation_id)->firstOrNew();
    }

    // Set transaction details
    $transaction->account_id = memberAccountId($account_id);
    $transaction->type = $type === 'deposit' ? 'credit' : 'debit';
    $transaction->previous_amount = $previousBalance;
    $transaction->amount = $amount;
    $transaction->current_amount = $type === 'deposit' ? $previousBalance + $amount : $previousBalance - $amount;
    $transaction->description = $description;
    $transaction->date = $transDate;

    // Set operation ID based on type
    if ($type == 'deposit') {
        $transaction->deposit_id = $operation_id;
    } else {
        $transaction->withdraw_id = $operation_id;
    }

    // Save transaction
    $transaction->save();

    // Prepare data for accounting transactions
    $data = [
        'amount' => $type === 'withdraw' ? - ($accountingUtil->num_uf($amount)) : $accountingUtil->num_uf($amount),
        'accounting_account_id' => $account_id,
        'created_by' => auth()->user()->id,
        'operation_date' => $transDate,
        'type' => $type === 'deposit' ? 'credit' : 'debit',
        'sub_type' => $type,
    ];

    // Set operation ID in accounting data
    if ($type == 'deposit') {
        $data['deposit_id'] = $operation_id;
    } else {
        $data['withdraw_id'] = $operation_id;
    }

    // Update or create AccountingAccountsTransaction based on operation type
    if ($type == 'deposit') {
        $accTransaction = AccountingAccountsTransaction::where('deposit_id', $operation_id)->first();
    } else {
        $accTransaction = AccountingAccountsTransaction::where('withdraw_id', $operation_id)->first();
    }

    // If transaction exists, update it, otherwise create a new one
    if ($accTransaction) {
        $accTransaction->update($data);
    } else {
        AccountingAccountsTransaction::create($data);
    }

    // Optionally update the account balance directly (if needed)
    // if ($type === 'withdraw') {
    //     $account->opening_balance -= $amount;
    // } else {
    //     $account->opening_balance += $amount;
    // }
    // $account->save();
}

/**
 * Retrieves the member account id as stored in MemberAccount model
 *using the id as stored in the AccountingAccounts model 
 * @param [type] $account_id
 * @return mixed
 */
function memberAccountId($account_id)
{
    $account = AccountingAccount::where('id', $account_id)->first();
    $memberAcc = MemberAccount::where('account_no', $account->name)->first();
    if ($memberAcc) {
        return $memberAcc->id;
    }
}


if (!function_exists('greeting')) {
    /**
     * Generate a greeting message based on the time of day.
     *
     * @return string
     */
    function greeting()
    {
        $currentHour = (int) date('G'); // Get the current hour in 24-hour format

        if ($currentHour >= 5 && $currentHour < 12) {
            return 'Good morning';
        } elseif ($currentHour >= 12 && $currentHour < 17) {
            return 'Good afternoon';
        } elseif ($currentHour >= 17 && $currentHour < 21) {
            return 'Good evening';
        } else {
            return 'Good night';
        }
    }
}

function getSystemInfo()
{
    $businessId = request()->attributes->get('business_id');

    if ($businessId) {
        return Tenants::find($businessId);
    }

    return null;
}
if (!function_exists('formatPermission')) {
    function formatPermission($permission)
    {
        // Split the string by dot (.)
        $parts = explode('_', $permission);

        // Capitalize the first letter of each part and join with a space
        return implode(' ', array_map('ucfirst', $parts));
    }

}

function getModule($permission) {
    if (strpos($permission, 'loan_product') !== false) {
        return ['module' => 'Loans', 'submodule' => 'Loan Product'];
    } elseif (strpos($permission, 'loan_repayment') !== false) {
        return ['module' => 'Loans', 'submodule' => 'Loan Repayment'];
    } elseif (strpos($permission, 'loan_calculator') !== false) {
        return ['module' => 'Loans', 'submodule' => 'Loan Calculator'];
    }elseif (strpos($permission, 'loan_dashboard') !== false) {
        return ['module' => 'Loans', 'submodule' => 'Loan Dashboard'];
    } elseif (strpos($permission, 'loans') !== false) {
        return ['module' => 'Loans', 'submodule' => 'Main'];
    }elseif (strpos($permission, 'accounting_transfer') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Transfer'];
    }
    elseif (strpos($permission, 'accounting_journal_entry') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Journal Entry'];
    } elseif (strpos($permission, 'accounting_account') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Accounting Accounts'];
    }elseif (strpos($permission, 'accounting_transactions') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Transactions'];
    }elseif (strpos($permission, 'accounting_budgets') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Budgets'];
    }elseif (strpos($permission, 'accounting_detail_type') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Accounting Detail Types'];
    }elseif (strpos($permission, 'accounting_reports') !== false) {
        return ['module' => 'Accounting', 'submodule' =>'Accounting Reports'];
    }elseif (strpos($permission, 'accounting') !== false) {
        return ['module' => 'Accounting', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'role_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Roles'];
    }elseif (strpos($permission, 'fee_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Fees'];
    } elseif (strpos($permission, 'collateral_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Collaterals'];
    }elseif (strpos($permission, 'account_types_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Account Types'];
    }elseif (strpos($permission, 'exchange_rates_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Exchange Rates'];
    }elseif (strpos($permission, 'generate_system_backup') !== false) {
        return ['module' => 'Settings', 'submodule' => 'System Backup'];
    }elseif (strpos($permission, 'system_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'System Information'];
    }elseif (strpos($permission, 'prefix_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Prefixes'];
    }elseif (strpos($permission, 'loan_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Loans'];
    }elseif (strpos($permission, 'logo_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Logo'];
    }elseif (strpos($permission, 'email_settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Email'];
    }elseif (strpos($permission, 'settings') !== false) {
        return ['module' => 'Settings', 'submodule' => 'Main'];
    }elseif (strpos($permission, 'investments') !== false) {
        return ['module' => 'Investments', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'investors') !== false) {
        return ['module' => 'Investments', 'submodule' => 'Investors'];
    }elseif (strpos($permission, 'investment_plan') !== false) {
        return ['module' => 'Investments', 'submodule' =>'Investment Plan'];
    }elseif (strpos($permission, 'shares') !== false) {
        return ['module' => 'Investments', 'submodule' =>'Shares'];
    } elseif (strpos($permission, 'staff') !== false) {
        return ['module' => 'Staff', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'members') !== false) {
        return ['module' => 'Members', 'submodule' => 'Main'];
    }
    elseif (strpos($permission, 'branch') !== false) {
        return ['module' => 'Branch', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'roles') !== false) {
        return ['module' => 'Roles', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'reports') !== false) {
        return ['module' => 'Reports', 'submodule' => 'Main'];
    }  elseif (strpos($permission, 'savings') !== false) {
        return ['module' => 'Savings', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'assets') !== false) {
        return ['module' => 'Assets', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'branches') !== false) {
        return ['module' => 'Branches', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'expenses') !== false) {
        return ['module' => 'Expenses', 'submodule' => 'Main'];
    } elseif (strpos($permission, 'dashboard') !== false) {
        return ['module' => 'Dashboard', 'submodule' => 'Main'];
    }elseif (strpos($permission, 'category') !== false) {
        return ['module' => 'Expenses', 'submodule' =>'Category'];
    }elseif (strpos($permission, 'funds_deposits') !== false) {
        return ['module' => 'Funds', 'submodule' =>'Deposits'];
    }elseif (strpos($permission, 'funds_withdrawals') !== false) {
        return ['module' => 'Funds', 'submodule' =>'Withdrawals'];
    }elseif (strpos($permission, 'funds_transfers') !== false) {
        return ['module' => 'Funds', 'submodule' =>'Transfers'];
    }elseif (strpos($permission, 'funds') !== false) {
        return ['module' => 'Funds', 'submodule' =>'Main'];
    }

    return null; // No module found
}

if (!function_exists('unauthorizedAccess')) {
    /**
     * Handle unauthorized access by flashing a notification and redirecting back.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    function unauthorizedAccess($message = 'Unauthorized access to page!')
    {
        $notify[] = ['error', $message];
        session()->flash('notify', $notify);
        return redirect()->back();
    }
}

if(!function_exists('getTitles')){
    /**
     * Get different titles
     *
     * @return array
     */
    function getTitles():array
    {
        $titles = [
            'Mr',         // Mister
            'Mrs',        // Mistress (married woman)
            'Miss',       // Unmarried woman
            'Ms',         // General female title (marital status unspecified)
            'Mx',         // Gender-neutral title
        
            'Dr',         // Doctor
            'Prof',       // Professor
            'Eng',        // Engineer
        
            'Fr',         // Father (Catholic clergy)
            'Rev',        // Reverend (Christian clergy)
            'Pst',        // Pastor
            'Bp',         // Bishop
            'Archbp',     // Archbishop
            'Elder',      // Elder in some denominations
            'Deacon',     // Deacon
        
            'Imam',       // Islamic religious leader
            'Sheikh',     // Islamic scholar or elder
            'Rabbi',      // Jewish religious leader
        
            'Hon',        // Honorable (often used for politicians)
            'Sir',        // Knighted male
            'Dame',       // Knighted female
            'Lord',       // Male noble title
            'Lady',       // Female noble title
        
            'Bro',        // Brother (commonly used in religious communities)
            'Sis',        // Sister (religious or respectful term)
        
            'Chief',      // Traditional or cultural leader
            'Hajji',      // Male who has made pilgrimage to Mecca
            'Hajjati',  
        ];
        
        return $titles;
    }
}

if(!function_exists('getPackageForModules')){
    /**
     * Return available modules
     *
     * @return void
     */
    function getPackageForModules(){
        $modules=['accounting','savings','investments','loans','assets','reports'];
        return $modules;
    }
}

if (!function_exists('strip_hash_number')) {
    function strip_hash_number(string $value): string
    {
        return preg_replace('/#\d+$/', '', $value);
    }
}

if(!function_exists('getParentExpenseCategoryName')){
    function getParentExpenseCategoryName($categoryId):string
    {
         $selectedCategory = ExpenseCategory::find($categoryId);
         return $selectedCategory->name;
    }
}

if(!function_exists('createTenantPermissions'))
{
    /**
     * Create tenant Permissions
     *
     * @param [type] $tenant_id
     * @return void
     */
    function createTenantPermissions()
    {
       $permissions=[
        "access_loan_calculator",
        "add_account_types_settings",
        "add_accounting_account",
        "add_accounting_account_sub_type",
        "add_accounting_budgets",
        "add_accounting_detail_type",
        "add_accounting_journal_entry",
        "add_accounting_transactions",
        "add_accounting_transfer",
        "add_assets",
        "add_assets_group",
        "add_assets_supplier",
        "add_branch",
        "add_category",
        "add_collateral_settings",
        "add_exchange_rates_settings",
        "add_expenses",
        "add_fee_settings",
        "add_funds_deposits",
        "add_funds_transfers",
        "add_funds_withdrawals",
        "add_investment_plan",
        "add_investments",
        "add_investors",
        "add_loan_product",
        "add_loan_repayment",
        "add_loan_settings",
        "add_loans",
        "add_members",
        "add_members_account",
        "add_prefix_settings",
        "add_role_settings",
        "add_savings",
        "add_shares",
        "add_staff",
        "approve_loans",
        "assign_roles",
        "create_roles",
        "delete_account_types_settings",
        "delete_accounting_account",
        "delete_accounting_account_sub_type",
        "delete_accounting_budgets",
        "delete_accounting_detail_type",
        "delete_accounting_journal_entry",
        "delete_accounting_transactions",
        "delete_accounting_transfer",
        "delete_assets",
        "delete_assets_group",
        "delete_assets_supplier",
        "delete_branch",
        "delete_category",
        "delete_collateral_settings",
        "delete_exchange_rates_settings",
        "delete_expenses",
        "delete_fee_settings",
        "delete_funds_deposits",
        "delete_funds_transfers",
        "delete_funds_withdrawals",
        "delete_investment_plan",
        "delete_investments",
        "delete_investors",
        "delete_loan_product",
        "delete_loan_repayment",
        "delete_loan_settings",
        "delete_loans",
        "delete_members",
        "delete_members_account",
        "delete_prefix_settings",
        "delete_reports",
        "delete_role_settings",
        "delete_roles",
        "delete_savings",
        "delete_shares",
        "delete_staff",
        "disburse_loans",
        "edit_account_types_settings",
        "edit_accounting_account",
        "edit_accounting_account_sub_type",
        "edit_accounting_budgets",
        "edit_accounting_detail_type",
        "edit_accounting_journal_entry",
        "edit_accounting_transactions",
        "edit_accounting_transfer",
        "edit_assets",
        "edit_assets_group",
        "edit_assets_supplier",
        "edit_branch",
        "edit_category",
        "edit_collateral_settings",
        "edit_exchange_rates_settings",
        "edit_expenses",
        "edit_fee_settings",
        "edit_funds_deposits",
        "edit_funds_transfers",
        "edit_funds_withdrawals",
        "edit_investment_plan",
        "edit_investments",
        "edit_investors",
        "edit_loan_product",
        "edit_loan_repayment",
        "edit_loan_settings",
        "edit_loans",
        "edit_members",
        "edit_members_account",
        "edit_prefix_settings",
        "edit_role_settings",
        "edit_roles",
        "edit_savings",
        "edit_shares",
        "edit_staff",
        "export_accounting_reports",
        "export_reports",
        "generate_reports",
        "generate_system_backup",
        "reconcile_accounting_accounts",
        "reject_loans",
        "review_loans",
        "update_email_settings",
        "update_logo_settings",
        "update_system_settings",
        "view_account_types_settings",
        "view_accounting_account_sub_type",
        "view_accounting_budgets",
        "view_accounting_charts_of_accounts",
        "view_accounting_dashboard",
        "view_accounting_detail_type",
        "view_accounting_journal_entry",
        "view_accounting_reports",
        "view_accounting_settings",
        "view_accounting_transactions",
        "view_accounting_transfer",
        "view_assets",
        "view_assets_group",
        "view_assets_reports",
        "view_assets_supplier",
        "view_branch",
        "view_category",
        "view_collateral_settings",
        "view_email_settings",
        "view_exchange_rates_settings",
        "view_expense_reports",
        "view_expenses",
        "view_expenses_overview_on_dashboard",
        "view_fee_settings",
        "view_funds_deposits",
        "view_funds_details",
        "view_funds_receipts",
        "view_funds_transfers",
        "view_funds_withdrawals",
        "view_investment_plan",
        "view_investment_reports",
        "view_investments",
        "view_investors",
        "view_investors_dashboard",
        "view_loan_dashboard",
        "view_loan_overview_on_dashboard",
        "view_loan_products",
        "view_loan_repayment_schedule",
        "view_loan_repayments",
        "view_loan_reports",
        "view_loan_settings",
        "view_loans",
        "view_logo_settings",
        "view_main_dashboard",
        "view_member_reports",
        "view_members",
        "view_members_account",
        "view_members_account_statement",
        "view_members_dashboard",
        "view_own_loans",
        "view_prefix_settings",
        "view_recent_transactions_on_dashboard",
        "view_revenues_overview_on_dashboard",
        "view_role_settings",
        "view_roles",
        "view_savings",
        "view_savings_overview_on_dashboard",
        "view_savings_reports",
        "view_shares",
        "view_staff",
        "view_staff_dashboard",
        "view_statistics_overview_on_dashboard",
        "view_system_settings"
       ];

        return $permissions;
    }
}


if(!function_exists('isUserNumberLimitExceeded')) {
    /**
     * check if allowable user number on package is not exceeded
     *
     * @return boolean
     */
    function isUserNumberLimitExceeded()
    {
      $userLimit = 0;
      $tenant = Session::get('tenant') ?? Auth::guard('webmaster')->user()->tenant;
      $activePackage = $tenant->activePackage();
      $userLimit = $activePackage?->package?->number_of_users ?? 0;

      // StaffMember uses BelongsToTenant trait, so the count is scoped to the current tenant.
        $userCount = StaffMember::count();
        // 0 means unlimited users allowed
        if ($userLimit === 0) {
            return false;
        }

        return $userCount >= $userLimit;
    }
}




