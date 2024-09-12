<?php

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\Asset;
use App\Models\Group;

use App\Models\Branch;

use App\Models\Lender;
use App\Models\Member;

use App\Models\Company;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\GroupLoan;

use App\Models\Investment;
use App\Models\MemberLoan;
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
use App\Utilities\Util;

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
    $setting = Setting::find(1);
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
    $setting = Setting::find(1);
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
    $setting = Setting::find(1);
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

function showAmount($amount, $decimal = 2, $separate = true)
{
    $gs = Setting::first();
    $separator = '';
    if ($separate) {
        $separator = ',';
    }
    $currencySymbol = '<small class="mr-1" style="font-size:14px"> ' . $gs->currency_symbol . '</small>';
    $printAmount = $currencySymbol . number_format($amount, $decimal, '.', $separator);
    $exp = explode('.', $printAmount);
    if ($exp[1] * 1 == 0) {
        $printAmount = $exp[0];
    }

    return $printAmount;
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
    function generateMemberUniqueID(string $sys_prefix = null, string $gender = null, string $dob)
    {
        // Get the latest member ID and increment it
        $latestMember = Member::latest('id')->first();
        $latestId = $latestMember ? $latestMember->id + 1 : 1;
        $prefix_code = $sys_prefix !== null ? $sys_prefix : "'MBR'";
        // Generate unique member ID
        $uniqueMemberId = $prefix_code . $dob . strtoupper($gender[0]) . $latestId;
        return $uniqueMemberId;
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
        $settings = Setting::find(1);
        $collateralMethods = explode(',', $settings->collateral_methods);
        return $collateralMethods;
    }
}


function showAmountPdf($amount, $decimal = 2, $separate = true)
{
    $gs = Setting::first();
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
    $gs = Setting::first();
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
    $setting = Settings::first();
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
function insertAccountTransaction($account_id, $type, $amount, $description, $transDate,$operation_id)
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
    $transaction->operation=$type === 'deposit' ? 'deposit' : 'withdraw';
    $transaction->previous_amount = $previousBalance;
    if($type =='deposit' )
    {
        $transaction->deposit_id =$operation_id;
    }else{
        $transaction->withdraw_id =$operation_id;
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
        'amount'=>$accountingUtil->num_uf($amount),
        'accounting_account_id' => $account_id,
        'created_by' => auth()->user()->id,
        'operation_date' => $transDate,
        'type' => $type === 'deposit' ? 'credit' : 'debit',
        'sub_type' => $type,
    ];

    if($type =='deposit' )
    {
        $data['deposit_id'] =$operation_id;
    }else{
        $data['withdraw_id'] =$operation_id;
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
        'amount' => $type === 'withdraw' ? -($accountingUtil->num_uf($amount)) : $accountingUtil->num_uf($amount),
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
