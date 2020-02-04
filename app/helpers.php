<?php
if (!function_exists('validateCaptcha')) {
    function validateCaptcha($response)
    {
        $recaptcha = new \ReCaptcha\ReCaptcha(env('GOOGLE_RECAPTCHA_SECRET_KEY'));
        $res = $recaptcha->verify($response, _server('REMOTE_ADDR'));

        return $res->isSuccess();
    }
}
