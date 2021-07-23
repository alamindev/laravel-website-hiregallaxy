<?php

function isHTML($string)
{
    if ($string != strip_tags($string)) {
        return true;
    } else {
        return false;
    }
}
