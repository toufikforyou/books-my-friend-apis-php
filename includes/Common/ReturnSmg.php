<?php
namespace Includes\Common;

class ReturnSmg
{

    public static function return(int $statusCode, bool $status, $desc): string
    {
        return json_encode([
            'code' => $statusCode,
            'success' => $status,
            'result' =>  $desc,
            'language' => $_SERVER['HTTP_X_LANG'] ?? 'bn',
            'timestamp' => date("Y-m-d H:i:s", time())
        ]);
    
    }
}