<?php

namespace Services\Models\Requestable;

use Services\Database\SLWDatabase;

class MyBooksModel extends SLWDatabase
{
    protected function fetchMyAllBooks(string $uid): ?array
    {

        try {
            $conn = $this->connect();
            $conn->beginTransaction();

            $sql = 'SELECT `BID` as `bid`,
            `BNAME` as `bname`,
            `STATUS` as `status`,
            `DESCRIPTION` as `description`,
            `AUTHOR` as `author`,
            `LANGUAGE` as `language`,
            `PUBLISHER` as `publisher`,
            `CATEGORY` as `category`,
            `COVER` as `cover`,
            `PRICE` as `price`,
            `EPRICE` as `eprice`,
            `UID` as `uid`,
            `PAGE` as `page`,
            `SUBJECT` as `subject`,
            `ABOUT` as `about`,
            `ONUPDATE` as `update`
            FROM `BMF_WRITTING_BOOKS` WHERE `UID` = :userId and `STATUS` != 1 ORDER BY `ONUPDATE` DESC;';

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":userId", htmlspecialchars($uid), \PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                $conn->commit();
                return array('error' => 1, 'result' => 'Books not found!');
            }

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);


            $response = array('success' => 1, 'result' =>  $result);

            $conn->commit();
        } catch (\PDOException $e) {
            $conn->rollBack();

            $response = array('error' => -1, 'result' => 'Something is wrong please try agin later!');
        }


        return $response;
    }
}
