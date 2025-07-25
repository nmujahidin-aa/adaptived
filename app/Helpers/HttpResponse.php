<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class HttpResponse
{
    /**
     * Success HTTP response
     *
     * @param int $code HTTP code (Example: \Illuminate\Http\Response::HTTP_OK)
     * @param string $message Message
     * @param array $data Data
     * @return JsonResponse|Response HTTP response
     */
    public static function success(int $code, string $message, array $data = []) : JsonResponse|Response
    {
        if ($data != []) {
            return response()->json([
                'success' => true,
                'code' => $code,
                'status' => self::getStatusFromCode($code),
                'message' => $message,
                'data' => $data
            ], $code);
        } else {
            return response()->json([
                'success' => true,
                'code' => $code,
                'status' => self::getStatusFromCode($code),
                'message' => $message
            ], $code);
        }
    }

    /**
     * Fail HTTP response
     *
     * @param int $code HTTP code (Example: \Illuminate\Http\Response::HTTP_BAD_REQUEST)
     * @param string $message Message
     * @param array $data Data
     * @param array $errors Errors
     * @return JsonResponse|Response HTTP response
     */
    public static function fail(int $code, string $message, array $errors = [], array $data = []) : JsonResponse|Response
    {
        if ($data != []) {
            return response()->json([
                'success' => false,
                'code' => $code,
                'status' => self::getStatusFromCode($code),
                'message' => $message,
                'data' => $data,
                'errors' => $errors
            ], $code);
        } else {
            return response()->json([
                'success' => false,
                'code' => $code,
                'status' => self::getStatusFromCode($code),
                'message' => $message,
                'errors' => $errors
            ], $code);
        }
    }

    /**
     * Get status from HTTP code
     * Note: This function is only accessible from this class
     *
     * @param int $code HTTP code (Example: \Illuminate\Http\Response::HTTP_OK)
     * @return string Status
     */
    private static function getStatusFromCode(int $code): string
    {
        $data = [
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing', // WebDAV; RFC 2518
            103 => 'Early Hints', // RFC 8297
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information', // since HTTP/1.1
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content', // RFC 7233
            207 => 'Multi-Status', // WebDAV; RFC 4918
            208 => 'Already Reported', // WebDAV; RFC 5842
            226 => 'IM Used', // RFC 3229
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found', // Previously "Moved temporarily"
            303 => 'See Other', // since HTTP/1.1
            304 => 'Not Modified', // RFC 7232
            305 => 'Use Proxy', // since HTTP/1.1
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect', // since HTTP/1.1
            308 => 'Permanent Redirect', // RFC 7538
            400 => 'Bad Request',
            401 => 'Unauthorized', // RFC 7235
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Handler Required', // RFC 7235
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed', // RFC 7232
            413 => 'Payload Too Large', // RFC 7231
            414 => 'URI Too Long', // RFC 7231
            415 => 'Unsupported Media Type', // RFC 7231
            416 => 'Range Not Satisfiable', // RFC 7233
            417 => 'Expectation Failed',
            418 => 'I\'m a teapot', // RFC 2324, RFC 7168
            419 => 'Session Expired',
            421 => 'Misdirected Request', // RFC 7540
            422 => 'Unprocessable Entity', // WebDAV; RFC 4918
            423 => 'Locked', // WebDAV; RFC 4918
            424 => 'Failed Dependency', // WebDAV; RFC 4918
            425 => 'Too Early', // RFC 8470
            426 => 'Upgrade Required',
            428 => 'Precondition Required', // RFC 6585
            429 => 'Too Many Requests', // RFC 6585
            431 => 'Request Header Fields Too Large', // RFC 6585
            451 => 'Unavailable For Legal Reasons', // RFC 7725
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates', // RFC 2295
            507 => 'Insufficient Storage', // WebDAV; RFC 4918
            508 => 'Loop Detected', // WebDAV; RFC 5842
            510 => 'Not Extended', // RFC 2774
            511 => 'Network Handler Required', // RFC 6585
        ];

        return $data[$code];
    }
}
