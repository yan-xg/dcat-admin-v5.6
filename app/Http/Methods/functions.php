<?php

if (! function_exists('getUserId')) {
    function getUserId($uid = null){
        if($uid == null){
            return false;
        }

        $info = explode('_', base64_decode($uid));
        return $info;
    }
}
