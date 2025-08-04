<?php

namespace Services\Models\Requestable;

use Services\Database\SLWDatabase;
use Services\Models\Common\FilesUploader;

class CreateBookModel extends SLWDatabase
{
    protected function createBookRequestModel(array $book): ?array
    {
        $bid = $this->lastBookId();

        $random = rand(100000, 999999);
        $book_cover = "bmf_{$bid}_{$random}";

        // Create a temporary directory to store the uploaded image
        $directories = ["../../files.sopnolikhi.com/booksmyfriend/unpublish/{$book['uid']}/{$bid}/chapters"];

        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
        }



        // upload image
        if (FilesUploader::ImageUpload($book['cover'], $book_cover, "../../files.sopnolikhi.com/booksmyfriend/unpublish/{$book['uid']}/$bid", 576, 864, 60) === false) {
            return array('error' => 1, 'result' => 'Something is wrong file error!');
        }

        // Get the file extension
        $book_cover = "{$book_cover}." . pathinfo($book['cover']['name'], PATHINFO_EXTENSION);


        try {
            $conn = $this->connect();
            $conn->beginTransaction();

            $sql = 'INSERT INTO `BMF_WRITTING_BOOKS`(`BID`, `BNAME`, `DESCRIPTION`, `AUTHOR`, `LANGUAGE`, `PUBLISHER`, `CATEGORY`, `COVER`, `PRICE`, `EPRICE`, `UID`, `PAGE`, `SUBJECT`, `ABOUT`, `LOCATIONS`, `DETAILS`) VALUES (:bId, :bName, :bDesc, :bAuthor, :bLang, :bPub, :bCat, :bCover, :bPrice, :bEPrice, :bUid, :bPage, :bSubject, :bAbout, :locations, :details)';

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":bId", htmlspecialchars($bid), \PDO::PARAM_INT);
            $stmt->bindParam(":bName", htmlspecialchars($book['name']), \PDO::PARAM_STR);
            $stmt->bindParam(":bDesc", htmlspecialchars($book['description']), \PDO::PARAM_STR);
            $stmt->bindParam(":bAuthor", htmlspecialchars($book['author']), \PDO::PARAM_INT);
            $stmt->bindParam(":bLang", htmlspecialchars($book['language']), \PDO::PARAM_INT);
            $stmt->bindParam(":bPub", htmlspecialchars($book['publisher']), \PDO::PARAM_INT);
            $stmt->bindParam(":bCat", htmlspecialchars($book['category']), \PDO::PARAM_INT);
            $stmt->bindParam(":bCover", htmlspecialchars($book_cover), \PDO::PARAM_STR);
            $stmt->bindParam(":bPrice", htmlspecialchars($book['price']), \PDO::PARAM_STR);
            $stmt->bindParam(":bEPrice", htmlspecialchars($book['eprice']), \PDO::PARAM_STR);
            $stmt->bindParam(":bUid", htmlspecialchars($book['uid']), \PDO::PARAM_STR);
            $stmt->bindParam(":bPage", htmlspecialchars($book['page']), \PDO::PARAM_STR);
            $stmt->bindParam(":bSubject", htmlspecialchars($book['subject']), \PDO::PARAM_STR);
            $stmt->bindParam(":bAbout", htmlspecialchars($book['about']), \PDO::PARAM_STR);
            $stmt->bindParam(":locations", htmlspecialchars(json_encode($book['locations'])), \PDO::PARAM_STR);
            $stmt->bindParam(":details", htmlspecialchars(json_encode($book['device-info'])), \PDO::PARAM_STR);

            $stmt->execute();

            $response = array('success' => 1, 'result' => [
                'bid' => $bid,
                'name' => htmlspecialchars($book['name']),
                'cover' => $book_cover
            ]);

            $conn->commit();
        } catch (\PDOException $e) {
            $conn->rollBack();

            $response = array('error' => -1, 'result' => 'Something is wrong please try agin later!');
        }


        return $response;
    }



    private function lastBookId(): int
    {
        $bid = 1000;

        try {
            $conn = $this->connect();
            $conn->beginTransaction();

            $sql = 'SELECT `BID` FROM `BMF_WRITTING_BOOKS` ORDER BY `BID` DESC LIMIT 1;';

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            // TODO:: Return UID or user id (int)
            $bid = $result ? (int) $result['BID'] + 1 : $bid;

            $conn->commit();
        } catch (\PDOException $e) {
            $conn->rollBack();

            $bid = 0;
        }

        return $bid;
    }
}
