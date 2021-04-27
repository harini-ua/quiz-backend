<?php

if (!function_exists('selected'))
{
    /**
     * Add selected class or attribute
     *
     * @param $expr
     *
     * @return string
     */
    function selected($expr): string
    {
        if ($expr) {
            return 'selected';
        }

        return '';
    }

    /**
     * Add active class
     *
     * @param      $expr
     * @param bool $space
     *
     * @return string
     */
    function active($expr, $space = true): string
    {
        $class = 'active';
        if ($expr) {
            return $space ? ' '.$class : $class;
        }

        return '';
    }
}
