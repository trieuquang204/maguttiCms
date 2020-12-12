<?php

namespace App\maguttiCms\Tools;

use ReflectionClass;

/**
 * Abstract class that defines the possible EOLs.
 *
 * Example usage to get an EOL definition:
 * $lineFeed = EOLTypes::UNIX => returns '\n'
 *
 * Inverse example:
 * EOLTypes::typeOf("\n") => returns 'LF'
 *
 * @package App\maguttiCms\Tools
 */
abstract class EOLTypes
{
    const UNIX = "\n"; // Line Feed
    const TRS80 = "\r"; // Carriage Return (Apple)
    const ACORN = "\n\r"; // Line Feed Carriage Return
    const WINDOWS = "\r\n"; // Carriage Return Line Feed

    /**
     * This method is used to get a string representation of the given EOL.
     *
     * @param $type
     *
     * @return string
     */
    public static function typeOf($type): string
    {
        switch ($type) {
            case EOLTypes::UNIX:
                return 'LF';
            case EOLTypes::TRS80:
                return 'CR';
            case EOLTypes::ACORN:
                return 'LFCR';
            case EOLTypes::WINDOWS:
                return 'CRLF';
            default:
                return 'UNKNOWN';
        }
    }

    /**
     * This method is used to get an array of all the constants of the class.
     *
     * @return array
     */
    public static function toArray(): array
    {
        $self = new ReflectionClass(__CLASS__);
        return $self->getConstants();
    }
}

/**
 * Class used to detect line endings of strings and files.
 *
 * Example usage for string:
 * $eol = FileHelper::detectStringEOL('hello
 *                                     there');
 *
 * Example usage for files:
 * $eol = FileHelper::detectFileEOL('import.csv');
 *
 * @package App\maguttiCms\Tools
 */
class FileHelper
{
    /**
     * This method is used to detect the most frequent EOL in a string.
     *
     * @param $str
     *
     * @return string
     */
    public static function detectStringEOL($str): string
    {
        $eolTypes = EOLTypes::toArray();

        $mostFrequentCount = 0;
        $mostFrequentType = '';
        foreach ($eolTypes as $type) {
            if (($count = substr_count($str, $type)) > $mostFrequentCount) {

                // This is the most frequent EOL.
                $mostFrequentCount = $count;
                $mostFrequentType = $type;
            }
        }

        return $mostFrequentType;
    }

    /**
     * This method is used to detect the EOL of the first line of a file.
     *
     * @param $fileName
     *
     * @return bool|string
     */
    public static function detectFileEOL($fileName): string
    {
        // If the file doesn't exists just return an empty string meaning unknown EOL.
        if (!file_exists($fileName)) {
            return '';
        }

        $file = @fopen($fileName, 'r');

        // Return unknown EOL if there was an error opening the file.
        if ($file === false)
            return '';

        $firstLine = fgets($file);

        // Close the file and free up resources.
        fclose($file);

        // Finally detect the EOL type and return it.
        return FileHelper::detectStringEOL($firstLine);
    }
}
