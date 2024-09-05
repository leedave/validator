<?php

namespace Leedch\Validator;

/**
 * Class to handle user inputs
 * @author leed
 */
class Sanitize
{
    public static function email(string $email): string
    {
        $arrEmails = explode(";", (string) $email);
        $arrFiltered = [];
        foreach ($arrEmails as $email) {
            $arrFiltered[] = filter_var($email, FILTER_SANITIZE_EMAIL);
        }
        return implode(";", $arrFiltered);
    }

    public static function url(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Override this if you want different Tags to be allowed (not stripped)
     * @return array
     */
    public static function getWysiwygStripTags(): array
    {
        return ['h2','h3','h4','p','strong','i','a','ul','li','ol','br'];
    }

    public static function wysiwyg(string $content): string
    {
        /*
         * <h2>Header 1</h2>
         * <h3>Header 2</h3>
         * <h4>Header 3</h4>
         * <p>
         * <strong>Bold</strong></p>
         * <p><i>Italic</i></p>
         * <p><a href="https://www.leed.ch">Link&nbsp;</a></p>
         * <ul><li>Bullet List</li><li>bullet</li></ul>
         * <ol><li>Numbered List</li><li>Number two</li></ol><p>asdfasdf</p><p>&nbsp;</p>
         */
        $contentNoTag = strip_tags($content, static::getWysiwygStripTags());
        return (string) $contentNoTag;
    }

    public static function text(string $content): string
    {
        $contentNoTag = trim(strip_tags((string) $content));
        return (string) $contentNoTag;
    }

    public static function permission(string $content): string
    {
        $sanitized = preg_replace( '/[^a-zA-Z\/]+/', '', $content);
        return $sanitized;
    }

    /**
     * Sanitize Date String. Can return an empty string
     * @param string $date
     * @return string
     */
    public static function date(string $date): string
    {
        if ($date === "") {
            return "";
        }
        $timestamp = strtotime($date);
        return date("Y-m-d", $timestamp);
    }

    /**
     * Sanitize Date String. Can return an empty string
     * @param string $date
     * @return string
     */
    public static function datetime(string $date): string
    {
        if ($date === "") {
            return "";
        }
        $timestamp = strtotime($date);
        return date("Y-m-d H:i:s", $timestamp);
    }

    /**
     * Sanitize for use as File Name
     * @param string $fileName
     * @return string
     */
    public static function fileName(string $fileName): string
    {
        $arrParts = explode(".", (string) $fileName);
        $suffix = array_pop($arrParts);
        $nameWithoutSuffix = implode("", $arrParts);
        $namesanitized = preg_replace( '/[^a-z0-9]+/', '-', $nameWithoutSuffix);
        $suffixSanitized = preg_replace( '/[^a-z0-9]+/', '-', $suffix);
        $response = ($suffixSanitized !== "")?$namesanitized.".".$suffixSanitized:$namesanitized;
        return $response;
    }

    /**
     * Sanitize for use as Variable Name
     * @param string $text
     * @return string
     */
    public static function varName(string $text): string
    {
        $namesanitized = preg_replace( '/[^a-z0-9]+/', '-', strtolower($text));
        return $namesanitized;
    }

    public static function keywords(array $keywords): string
    {
        $response = [];
        foreach ($keywords as $keyword) {
            $keywordFix = preg_replace('/[^\p{L}\p{N}]/u', " ", strtolower($keyword));
            $response[] = $keywordFix;
        }
        return implode(";", $response);
    }

    /**
     * Sorting Directions allowed
     * @param string $sortDir
     * @return string
     */
    public static function sortDir(string $sortDir): string
    {
        $allowed = ['ASC', 'DESC'];
        if (!isset($sortDir) || !in_array($sortDir, $allowed)) {
            return "";
        }
        return (string) $sortDir;
    }

    /**
     * Override this for allowed names in sortName
     * @return array
     */
    public static function getSortNameAllowed(): array
    {
        return ['date', 'text', 'amount', 'currency', 'typeId', 'categoryId', 'source'];
    }

    /**
     * Limit Sort Requests to allowed names
     * @param string $sort
     * @return string
     */
    public static function sortName(string $sort): string
    {
        if (!in_array($sort, static::getSortNameAllowed())) {
            return "";
        }
        return (string) $sort;
    }
}
