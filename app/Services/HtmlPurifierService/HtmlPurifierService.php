<?php

namespace App\Services\HtmlPurifierService;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlPurifierService
{
    /**
     * Sanitizes and purifies HTML content to allow only specific tags and attributes.
     *
     * @param string $html The HTML content to be sanitized.
     *
     * @return string The sanitized HTML content.
     */
    public function sanitizeComment(string $html): string
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', 'a[href|title],code,i,strong');

        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
    }
}
