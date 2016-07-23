<?php

namespace True\Data\RamSystem;

use InvalidArgumentException;
use True\Multilingual\Lang;

class ArrayQuery
{
    /**
     * Array of path to value
     *
     * @var array
     */
    private $path;

    /**
     * ArrayQuery constructor.
     *
     * @param string $query
     */
    public function __construct($query)
    {
        if (is_string($query)) {
            $this->path = explode('.', $query);
        } else {
            throw new InvalidArgumentException(Lang::get('exceptions.invalid_argument'));
        }
    }

    /**
     * Apply query to array
     *
     * @param array $data
     * @return mixed|null
     */
    public function apply($data) {
        static $iteration = 0;
        if (array_key_exists($data, $this->path[$iteration])) {
            $out = $data[$this->path[$iteration]];
        } else {
            trigger_error(Lang::get('notices.key_does_not_exist'));
            $out = null;
        }
        if ($iteration !== count($this->path)) {
            if (is_array($out)) {
                ++$iteration;
                self::apply($out);
            } else {
                trigger_error(Lang::get('notices.key_is_not_array'));
                $out = null;
            }
        }
        $iteration = 0;
        return $out;
    }
}