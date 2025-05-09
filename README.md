# input-validator  
Reusable PHP input validation functions (WordPress-compatible)

### Features

- **fc_validate_email()** → Uses WordPress `is_email()` if available, fallback to PHP `filter_var()`.
- **fc_validate_phone()** → Strips separators and validates US/Canada 10-digit phone numbers (basic international support).
- **fc_is_field_empty()** → Checks if a value is empty after trimming.

### Usage

See `input-validator.php` for CLI demo and example usage.

> ⚠ **Note:** These functions validate input but do not sanitize or escape data for storage/output.

### Author

Freedom Chevalier  
[GitHub Profile](https://github.com/chevaliercreates/)
