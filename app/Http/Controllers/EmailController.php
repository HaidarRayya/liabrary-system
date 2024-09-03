<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public static function borrowBook($mailData, $to)
    {
        try {
            $GLOBALS['x'] = $to;
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("استعارة كتاب");
            });
        } catch (Exception $ex) {
        }
    }
    public static function warningDelayBorrow($mailData, $to)
    {
        try {
            $GLOBALS['x'] = $to;
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("تحذير موعد اعادة الكتاب");
            });
        } catch (Exception) {
        }
    }
    public static function nowReturnBook($mailData, $to)
    {
        try {
            $GLOBALS['x'] = $to;
            Mail::send('email', [
                'data' => $mailData
            ], function ($message) {
                $message->to($GLOBALS['x']);
                $message->subject("عدم اعادة الكتاب");
            });
        } catch (Exception $ex) {
        }
    }
}
