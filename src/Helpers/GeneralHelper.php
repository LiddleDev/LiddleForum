<?php

namespace LiddleDev\LiddleForum\Helpers;

class GeneralHelper
{
    public static function getTimeAgo(\DateTime $date = null)
    {
        if ( ! $date) {
            return '-';
        }

        $seconds = time() - $date->getTimestamp();

        $amount = null;
        $word = null;

        if ($seconds >= (60 * 60 * 24 * 60)) {
            $amount = round($seconds / (60 * 60 * 24 * 30));
            $word = 'month';
        } else if ($seconds >= (60 * 60 * 24)) {
            $amount = round($seconds / (60 * 60 * 24));
            $word = 'day';
        } else if ($seconds >= (60 * 60)) {
            $amount = round($seconds / (60 * 60));
            $word = 'hour';
        } else if ($seconds >= 60) {
            $amount = round($seconds / 60);
            $word = 'minute';
        }

        if ($amount && $word) {
            $amount = intval($amount);

            return number_format($amount) . ' ' . $word . ($amount === 1 ? '' : 's') . ' ago';
        }

        return 'just now';
    }
}
