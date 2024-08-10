<?php

use Carbon\Carbon;
use App\Models\Member;
use App\Models\Setting;
use App\Models\Loan;

use App\Models\JournalEntry;

use App\Models\ChartOfAccount;
use App\Models\AccountTransaction;

use App\Models\GroupLoan;
use App\Models\MemberLoan;
use App\Models\MemberAccount;
use App\Models\ShareAccount;

use App\Models\Branch;
use App\Models\StaffMember;
use App\Models\Asset;
use App\Models\Investment;
use App\Models\Group;
use App\Models\Company;
use App\Models\Lender;
use App\Models\SavingProduct;
use App\Models\Supplier;

use App\Models\SavingWeek;
use App\Models\SavingYear;

use App\Models\AnalyticsVisitor;
use App\Models\AnalyticsPage;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


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
    if(is_array($route)) {
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

function usernameGenerate($email){
    $explodeEmail = explode('@', $email);
    $username = $explodeEmail[0];
    return $username;
}



if (!function_exists('slug_create') ) {
    function slug_create($val) {
        $slug = Str::slug($val);
        return $slug;
    }
}

function slugCreate($val) {
    $slug = Str::slug($val);
    return $slug;
}

function generateTxnNumber() {
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
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'MBR';
    $latestId = Loan::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $loanNumber = $prefix_code . $randomString . $nextNumber;

    return $loanNumber;
}

function generateGroupLoanNumber() 
{
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'GRL';
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
    $characters       = '1234567890';
    $length = 5;
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    $prefix_code = 'GRL';
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
    $nextNumber = $latestId ? str_pad($latestId + 1, 3, '0', STR_PAD_LEFT) : '001';
    $memberNumber = $prefix_code . $randomString . $nextNumber;

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
    $printAmount = $currencySymbol.number_format($amount, $decimal, '.', $separator);
        $exp = explode('.', $printAmount);
        if ($exp[1] * 1 == 0) {
            $printAmount = $exp[0];
        }
    
    return $printAmount;
}

if (!function_exists('formattedAmount')) {
    function formattedAmount($amount,$decimal = 2, $separate = true) {
        $separator = '';
        if ($separate) {
            $separator = ',';
        }
        $printAmount = number_format($amount, $decimal, '.', $separator);
        return $printAmount;
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
    $printAmount = $currencySymbol.number_format($amount, $decimal, '.', $separator);
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
    $printAmount = $gs->currency_symbol.number_format($amount, $decimal, '.', $separator);
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
        }else{
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
   if (empty($savedVisitor) || @$savedVisitor->country =="unknown") {

      $info = json_decode(json_encode(getIpInfomation()), true);
      $city = isset($info['city']) && is_array($info['city']) ? implode(',', $info['city']) : '';
      $region = isset($info['area']) && is_array($info['area']) ? implode(',', $info['area']) : '';
      $time = isset($info['time']) && is_array($info['time']) ? implode(',', $info['time']) : '';
      $country_code = isset($info['code']) && is_array($info['code']) ? implode(',', $info['code']) : '';
      $country = isset($info['country']) && is_array($info['country']) ? implode(',', $info['country']) : '';
      $location = $city. ' - '.$region.' - '.$country.' - '.$country_code.' - '.$time;

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
   }else{
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
         return str_replace('OPR', 'Opera',
         $browser);
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
        (Request::has('HTTP_X_WAP_PROFILE') || Request::has('HTTP_PROFILE'))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($userAgent, 0, 4));
    $mobile_agents = array(
        'w3c', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac', 'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
        'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-', 'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
        'newt', 'noki', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox', 'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
        'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-', 'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
        'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
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



function generateBranchNumber() {
    $prefix_code = 'BR';
    $latestId = Branch::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateStaffNumber() {
    $prefix_code = 'ST';
    $latestId = StaffMember::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateAssetNumber() {
    $prefix_code = 'AST';
    $latestId = Asset::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}
function generateInvestmentNumber() {
    $prefix_code = 'IVT';
    $latestId = Investment::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateSupplierNumber() {
    $prefix_code = 'SUP';
    $latestId = Supplier::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateGroupNumber() {
    $prefix_code = 'GRP';
    $latestId = Group::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateCompanyNumber() {
    $prefix_code = 'CPY';
    $latestId = Company::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateLenderNumber() {
    $prefix_code = 'LDR';
    $latestId = Lender::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}

function generateSavingProductNumber() {
    $prefix_code = 'LDR';
    $latestId = SavingProduct::latest()->value('id');
    $nextNumber = $latestId ? str_pad($latestId + 1, 4, '0', STR_PAD_LEFT) : '0001';
    $code = $prefix_code . $nextNumber;
    return $code;
}


function insertAccountTransaction($account_id, $type, $amount, $description) {
    $account = ChartOfAccount::where('id', $account_id)->first();

    $transaction = new AccountTransaction();
    $transaction->account_id = $account_id;
    $transaction->type = $type;
    $transaction->previous_amount = $account->opening_balance;
    $transaction->amount = $amount;
    $transaction->current_amount = $account->opening_balance + $amount;
    $transaction->description = $description;
    $transaction->date = date('Y-m-d');
    $transaction->save();

    $account->opening_balance -= $amount;
    $account->save();
}