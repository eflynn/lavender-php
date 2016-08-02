<?php

namespace Lavender;

class InputStream
{
    const eof = -1;

    private $str;
    private $start;
    private $pos;

    /**
     * InputStream constructor.
     * @param $str
     */
    public function __construct($str)
    {
        $this->str = $str;
        $this->start = 0;
        $this->pos = 0;
    }

    /**
     * @param $valid
     * @return bool
     */
    public function accept($valid)
    {
        if (strpos($valid, $this->peek()) !== false) {
            $this->pos++;
            return true;
        }

        return false;
    }

    /**
     * @param $valid
     */
    public function acceptRun($valid)
    {
        while (strpos($valid, $this->peek()) !== false) {
            $this->pos++;
        }
    }

    /**
     * @return string
     */
    public function peek()
    {
        return $this->str[$this->pos];
    }

    /**
     * @return string
     */
    public function next()
    {
        return $this->str[$this->pos++];
    }

    public function ignore()
    {
        $this->start = $this->pos;
    }

    /**
     * @return string
     */
    public function get()
    {
        $return = substr($this->str, $this->start, $this->pos - $this->start);
        return $return;
    }

    /**
     * @return string
     */
    public function emit()
    {
        $return = substr($this->str, $this->start, $this->pos - $this->start);
        $this->start = $this->pos;
        return $return;
    }
}