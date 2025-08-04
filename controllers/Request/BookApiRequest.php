<?php

namespace Controllers\Request;

use Includes\Common\ReturnSmg;

class BookApiRequest
{
    public static function getBooksList($param): void
    {
        $current_page = (int) $param['page'] ?? 1;
        // TODO: This line control by defalt page number return 1;
        $current_page === 0 ? $current_page += 1 : $current_page;

        $limit = 10;

        echo $current_page . $limit;
    }

    public static function getBookInfo($param): void
    {
        echo json_encode($param);
    }

    public static function getBookRead($param): void
    {
        echo json_encode($param);
    }
}
