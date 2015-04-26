<?php
/**
 * HRTime converts a duration to a human readable format.
 *
 * @author      Anders K. Madsen <lillesvin@gmail.com>
 * @package     NiceDuration
 * @license     MIT
 * @see         http://github.com/lillesvin/niceduration
 * @copyright   2015 Anders K. Madsen
 */
namespace NiceDuration;

class NiceDuration
{
    private $duration;

    /**
     * @var     int         Duration to convert in seconds
     */
    private $durationSeconds;

    /**
     * @var     float       Any duration resolution lower than seconds
     */
    private $durationFraction;

    /**
     * @var     int         Precision of fractional seconds
     */
    private $fractionPrecision = 3;

    /**
     * @var     int         Cutoff point for returning fractional seconds
     */
    private $fractionCutoff = 43200; // 12 hours

    /**
     * @internal
     * @var     int         Duration of a year in seconds
     */
    private $yearInSeconds = 31536000;

    /**
     * @internal
     * @var     int         Duration of a day in seconds
     */
    private $dayInSeconds    = 86400;

    /**
     * @internal
     * @var     int         Duration of an hour in seconds
     */
    private $hourInSeconds   = 3600;

    /**
     * @internal
     * @var     int         Duration of a minute in seconds
     */
    private $minuteInSeconds = 60;

    /**
    * Instantiates NiceDuration and sets durationSeconds and durationFraction
    *
    * @param    float $duration     Duration to convert
    * @param    int $precision      Timing precision (default: 3)
    * @return   object NiceDuration
    * @magic
    */
    public function __construct($duration, $precision = 3)
    {
        $this->duration          = $this->validateFloat($duration);
        $this->fractionPrecision = $precision;
        $this->durationSeconds   = (int)$this->duration;
        $this->durationFraction  = bcsub(
            abs($this->duration),
            floor(abs($this->duration)),
            $this->fractionPrecision + 1 // Attempt to avoid rounding
        );
        $this->extractParts();
    }

    /**
     * Sets cutoff point for fractional seconds
     *
     * Durations greater than or equal to this threshold will not be
     * returned with fractions of seconds. Setting this to null/false disables
     * the cutoff altogether and always returns fractions.
     *
     * @param   float $limit        Threshold for showing fractional seconds
     * @return  void
     */
    public function setFractionCutoff($limit)
    {
        if (is_numeric($limit)) {
            $this->fractionCutoff = $this->validateFloat($limit);
        } else {
            $this->fractionCutoff = null;
        }
    }

    /**
     * Gets the cutoff point above which fractional seconds are not returned
     *
     * @return  float               Threshold for showing fractional seconds
     */
    public function getFractionCutoff()
    {
        return $this->fractionCutoff;
    }

    /**
     * Formats duration in a human redable format.
     *
     * Will try to return the shortest possible string so durations smaller
     * than e.g. a day aren't returned as e.g. "0y 0d 03:52:09.100".
     *
     * @return  string              Formatted duration
     */
    public function format()
    {
        $formatted = "";

        if ($this->duration >= $this->yearInSeconds) {
            $formatted .= sprintf("%dy ", $this->y);
        }
        if ($this->duration >= $this->dayInSeconds) {
            $formatted .= sprintf("%dd ", $this->d);
        }
        $formatted .= $this->formatTime();

        return $formatted;
    }

    /**
     * Formats the HH:MM:SS.SSS part of a duration
     *
     * Returns the shortest possible representation (still 0-padded though).
     * @uses NiceDuration::$fractionCutoff to determine whether or not to
     * return fractional seconds.
     *
     * @return  string          Formatted time
     */
    private function formatTime()
    {
        if ($this->duration >= $this->hourInSeconds) {
            if (!$this->returnFractions()) {
                return sprintf("%02d:%02d:%02d", $this->h, $this->m, $this->s);
            }
            return sprintf("%02d:%02d:%06.3f", $this->h, $this->m, ($this->s + $this->f));
        }
        if ($this->duration >= $this->minuteInSeconds) {
            if (!$this->returnFractions()) {
                return sprintf("%02d:%02d", $this->m, $this->s);
            }
            return sprintf("%02d:%06.3f", $this->m, ($this->s + $this->f));
        }
        if (!$this->returnFractions()) {
            return sprintf("%d", $this->s);
        }
        return sprintf("%05.3f", ($this->s + $this->f));
    }

    /**
     * Determines whether or not to return fractions for this duration
     *
     * @return  bool                    True if fractions should be returned
     */
    private function returnFractions()
    {
        return (is_null($this->fractionCutoff) || ((int)$this->duration < $this->fractionCutoff));
    }

    /**
     * Validates floats. Throws \NiceDuration\Exception on invalid floats
     *
     * @param   float $float            Float to validate
     * @throws  \NiceDuration\Exception On invalid values
     * @return  float                   Valid float
     */
    private function validateFloat($float)
    {
        $filtered = filter_var($float, FILTER_VALIDATE_FLOAT);
        if ($filtered !== false) {
            return $filtered;
        }
        throw new \NiceDuration\Exception('Invalid duration');
    }

    /**
     * Extracts discrete parts of the duration
     *
     * @return  void
     */
    private function extractParts()
    {
        $this->y = $this->getYears();
        $this->d = $this->getDays();
        $this->h = $this->getHours();
        $this->m = $this->getMinutes();
        $this->s = $this->getSeconds();
        $this->f = $this->getFraction();
    }

    /**
     * Extracts (and subtracts) year(s) from duration
     *
     * @return  void
     */
    private function getYears()
    {
        if ($this->durationSeconds >= $this->yearInSeconds) {
            $years = $this->durationSeconds / $this->yearInSeconds;
            $this->durationSeconds = $this->durationSeconds % $this->yearInSeconds;
            return $years;
        }
        return 0;
    }

    /**
     * Extracts (and subtracts) day(s) from duration
     *
     * @return  void
     */
    private function getDays()
    {
        if ($this->durationSeconds >= $this->dayInSeconds) {
            $days = $this->durationSeconds / $this->dayInSeconds;
            $this->durationSeconds = $this->durationSeconds % $this->dayInSeconds;
            return $days;
        }
        return 0;
    }

    /**
     * Extracts (and subtracts) hour(s) from duration
     *
     * @return  void
     */
    private function getHours()
    {
        if ($this->durationSeconds >= $this->hourInSeconds) {
            $hours = $this->durationSeconds / $this->hourInSeconds;
            $this->durationSeconds = $this->durationSeconds % $this->hourInSeconds;
            return $hours;
        }
        return 0;
    }

    /**
     * Extracts (and subtracts) minute(s) from duration
     *
     * @return  void
     */
    private function getMinutes()
    {
        if ($this->durationSeconds >= $this->minuteInSeconds) {
            $minutes = $this->durationSeconds / $this->minuteInSeconds;
            $this->durationSeconds = $this->durationSeconds % $this->minuteInSeconds;
            return $minutes;
        }
        return 0;
    }

    /**
     * Extracts seconds from duration
     *
     * @return  void
     */
    private function getSeconds()
    {
        return $this->durationSeconds;
    }

    /**
     * Gets the truncated (unrounded) fractional seconds
     *
     * @return  void
     */
    private function getFraction()
    {
        return $this->truncateFraction(
            $this->durationFraction,
            $this->fractionPrecision
        );
    }

    /**
     * Truncates float/int to $length decimal places without rounding
     *
     * @param   float|int $number       Number to truncate
     * @param   int $length             Desired number of decimal places
     * @return  float                   Truncated (unrounded) float
     */
    private function truncateFraction($number, $length)
    {
        $p = pow(10, $length);
        if ($number > 0) {
            return (float)floor($number * $p) / $p;
        } else {
            return (float)ceil($number * $p) / $p;
        }
    }
}

