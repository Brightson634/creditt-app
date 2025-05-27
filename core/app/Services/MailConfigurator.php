<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class MailConfigurator
{
    public static function apply($tenant)
    {
        Config::set('mail.default', 'smtp');

        Config::set('mail.mailers.smtp.transport', $tenant->mail_type);
        Config::set('mail.mailers.smtp.host', $tenant->smtp_host);
        Config::set('mail.mailers.smtp.port', $tenant->smtp_port);
        Config::set('mail.mailers.smtp.username', $tenant->email_user_name);
        // Config::set('mail.mailers.smtp.password', decrypt($tenant->smtp_password));
        Config::set('mail.mailers.smtp.password',$tenant->smtp_password);
        Config::set('mail.mailers.smtp.encryption', $tenant->mail_encryption);

        Config::set('mail.from.address', $tenant->from_email);
        Config::set('mail.from.name', $tenant->from_name);
    }
}
