<?php
/**
 * Simple Input Validator
 *
 * @package   Simple_Validator
 * @author    Freedom Chevalier
 * @license   MIT
 * @link      https://github.com/yourusername/
 * @version   1.1.0
 *
 * @description
 * Provides validation functions for common input types with WordPress integration.
 * Note: Always sanitize data before storage and escape before output.
 */

// Prevent direct file access
if (!defined('WPINC') && !defined('DOING_CRON') && !defined('REST_REQUEST')) {
    exit('Direct access forbidden');
}

/**
 * Validates email addresses using WordPress core or PHP filter.
 *
 * @param string $email Email address to validate.
 * @return bool Validation result.
 */
function fc_validate_email(string $email): bool {
    return function_exists('is_email') ? is_email($email) : filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validates phone numbers with international support.
 *
 * @param string $phone Phone number to validate.
 * @param string $country_code ISO country code (default: US).
 * @return bool Validation result.
 */
function fc_validate_phone(string $phone, string $country_code = 'US'): bool {
    $clean_phone = preg_replace('/[^0-9]/', '', $phone);

    // Basic international length check
    if (strlen($clean_phone) < 5 || strlen($clean_phone) > 15) {
        return false;
    }

    // Country-specific validation
    $country_code = strtoupper($country_code);
    switch ($country_code) {
        case 'US':
        case 'CA':
            return strlen($clean_phone) === 10;
        // Add other country cases here
        default:
            return false;
    }
}

/**
 * Checks if a field is empty after trimming.
 *
 * @param mixed $field Input to check.
 * @return bool True if empty.
 */
function fc_is_field_empty($field): bool {
    if (!is_scalar($field)) return true;
    return trim((string)$field) === '';
}

// Demo execution when run via CLI
if (php_sapi_name() === 'cli') {
    $tests = [
        'email' => [
            'test@example.com' => true,
            'invalid-email'    => false
        ],
        'phone' => [
            '(123) 456-7890'   => true,
            '123456'           => false
        ],
        'empty' => [
            '   '              => true,
            0                 => false,
            '0'               => false
        ]
    ];

    foreach ($tests as $type => $cases) {
        echo "Testing $type:\n";
        foreach ($cases as $value => $expected) {
            $result = match($type) {
                'email' => fc_validate_email($value),
                'phone' => fc_validate_phone($value),
                'empty' => fc_is_field_empty($value)
            };
            echo $result === $expected ? "✓ " : "✗ ";
            echo "$value => " . ($result ? 'valid' : 'invalid') . "\n";
        }
    }
}
