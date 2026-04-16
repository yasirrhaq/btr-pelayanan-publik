<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    /** @var GoogleTranslate|null */
    private static ?GoogleTranslate $translator = null;

    private static function translator(): GoogleTranslate
    {
        if (self::$translator === null) {
            self::$translator = new GoogleTranslate('en', 'id');
        }
        return self::$translator;
    }

    /**
     * Translate a plain text string from Indonesian to English.
     * Returns original text if locale is 'id' or string is blank.
     */
    public static function text(string $text): string
    {
        $text = trim($text);
        if (blank($text) || app()->getLocale() !== 'en') {
            return $text;
        }

        $cacheKey = 'trans_en_' . md5($text);

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text) {
            try {
                return self::translator()->translate($text) ?? $text;
            } catch (\Throwable $e) {
                return $text;
            }
        });
    }

    /**
     * Translate the visible text content of a full HTML page.
     *
     * Strategy:
     *  1. Mask <script>, <style>, <pre>, <code> blocks so they are never sent
     *     to the translation API.
     *  2. Extract every text node (content between > and <).
     *  3. De-duplicate and cache-translate each unique string.
     *  4. Put the translations back into the masked HTML.
     *  5. Restore the masked blocks.
     */
    public static function pageHtml(string $html): string
    {
        if (blank($html) || app()->getLocale() !== 'en') {
            return $html;
        }

        // --- Step 1: mask non-translatable blocks ---
        $masks = [];
        $masked = preg_replace_callback(
            '/<(script|style|pre|code|noscript|textarea)(\s[^>]*)?>.*?<\/\1>/is',
            function (array $match) use (&$masks): string {
                $placeholder = '__MASK_' . count($masks) . '__';
                $masks[$placeholder] = $match[0];
                return $placeholder;
            },
            $html
        );

        // --- Step 2: collect unique visible text strings ---
        $uniqueTexts = [];
        preg_match_all('/(?<=>)([^<>]+)(?=<)/u', $masked, $matches);

        foreach ($matches[1] as $raw) {
            $t = trim($raw);
            if (mb_strlen($t) < 2) {
                continue;
            }
            // Skip strings that look like placeholders, numbers-only, or pure symbols
            if (preg_match('/^[\d\s\W]+$/u', $t)) {
                continue;
            }
            $uniqueTexts[$t] = true;
        }

        if (empty($uniqueTexts)) {
            return $html;
        }

        // --- Step 3: batch-translate (each string cached independently) ---
        $translations = [];
        foreach (array_keys($uniqueTexts) as $text) {
            $cacheKey = 'trans_en_' . md5($text);
            $translations[$text] = Cache::remember(
                $cacheKey,
                now()->addDays(30),
                function () use ($text): string {
                    try {
                        return self::translator()->translate($text) ?? $text;
                    } catch (\Throwable $e) {
                        return $text;
                    }
                }
            );
        }

        // --- Step 4: replace text nodes in masked HTML ---
        $translated = preg_replace_callback(
            '/(?<=>)([^<>]+)(?=<)/u',
            function (array $match) use ($translations): string {
                $raw     = $match[1];
                $trimmed = trim($raw);
                if (!isset($translations[$trimmed])) {
                    return $raw;
                }
                // Preserve original leading/trailing whitespace
                $leading  = substr($raw, 0, strlen($raw) - strlen(ltrim($raw)));
                $trailing = substr($raw, strlen(rtrim($raw)));
                return $leading . $translations[$trimmed] . $trailing;
            },
            $masked
        );

        // --- Step 5: restore masked blocks ---
        return str_replace(array_keys($masks), array_values($masks), $translated ?? $html);
    }
}
