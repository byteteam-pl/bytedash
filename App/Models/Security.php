<?php

namespace Byte;

/**
 * Security
 */
class Security
{
    /**
     * Secure string before display him
     *
     * @param string $string
     * 
     * @return string
     * 
     */
    public static function sanitizeString($string)
    {
        return strip_tags(htmlspecialchars($string, ENT_QUOTES, 'UTF-8'));
    }
}
