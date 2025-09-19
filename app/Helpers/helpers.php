<?php

// Use Carbon
use Carbon\Carbon;

// Helper to convert datetime to format d-m-Y H:i:s
if (!function_exists('formatDateTime')) {
    function formatDateTime($dateTime)
    {
        return $dateTime
            ? Carbon::parse($dateTime)->format('d-m-Y H:i:s')
            : null;
    }
}