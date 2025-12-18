<?php

namespace App\Traits;

/**
 * Trait HasEnumHelpers
 *
 * Small collection of helper methods intended for backed enums.
 * Provides common utilities used when presenting enum values in UIs
 * (select options, labels) and when working with backed values
 * coming from storage or requests.
 *
 * Methods:
 * - `options()` returns an associative array of `value => label` suitable for form selects.
 * - `values()` returns a plain list of backing values.
 * - `labelFrom()` maps a backing value to a human-friendly label (or returns "Unknown").
 *
 * Notes:
 * - These helpers assume the enum is a backed enum (string/int). `tryFrom` and `from`
 *   are only available on backed enums.
 * - `defaultLabel()` converts underscores to spaces and title-cases the result; for
 *   full Unicode-aware casing consider `mb_convert_case(..., MB_CASE_TITLE, 'UTF-8')`.
 */
trait HasEnumHelpers
{
    /**
     * Convert a backing value into a basic human-readable label.
     *
     * This implementation replaces underscores with spaces, lower-cases
     * the string, and then title-cases each word.
     *
     * @param string $value Backing value of the enum case (e.g. "first_name").
     * @return string Human-friendly label (e.g. "First Name").
     */
    protected static function defaultLabel(string $value): string
    {
        return ucwords(strtolower(str_replace('_', ' ', $value)));
    }

    /**
     * Return an associative array of backing `value => label` for all enum cases.
     *
     * Useful for building HTML select options or other UI mappings.
     * If an enum case defines an instance `label()` method it will be used;
     * otherwise `defaultLabel()` is used as a fallback.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
        ->mapWithKeys(fn(self $case) => [
            $case->value => method_exists($case, 'label') 
            ? $case->label() : self::defaultLabel($case->value),
        ])
        ->toArray();
    }

    /**
     * Return a plain, indexed array of all enum backing values.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($c) => $c->value, self::cases());
    }

    /**
     * Map a backing value to a human-friendly label.
     *
     * If the provided value is `null` or an empty string this returns the
     * literal string "Unknown". When the value matches a defined enum case
     * and that case implements an instance `label()` method, that label is
     * returned. Otherwise the `defaultLabel()` fallback is used.
     *
     * @param string|null $value Backing value or null.
     * @return string Human-friendly label (never null).
     */
    public static function labelFrom(?string $value): string
    {
        if ($value === null || $value === '') {
            return 'Unknown';
        }

        $case = self::tryFrom($value);

        if ($case && method_exists($case, 'label')) {
            return $case->label();
        }

        return self::defaultLabel($value);
    }
}
