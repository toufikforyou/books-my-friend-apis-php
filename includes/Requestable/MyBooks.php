<?php

namespace Includes\Requestable;

use Includes\Common\ReturnSmg;
use Services\Controllers\Requestable\MyBooksCntr;

class MyBooks extends MyBooksCntr
{
    public function showMyAllBooks(string $uid): string
    {
        if (empty($uid)) {
            return ReturnSmg::return(1050, false, '701: Uid is empty');
        }

        return $this->requestMyAllBooks($uid);
    }
}