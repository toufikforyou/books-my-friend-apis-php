<?php

namespace Includes\Requestable;

use Includes\Common\ReturnSmg;
use Services\Controllers\Requestable\CreateBookCntr;

class CreateBook extends CreateBookCntr
{

    private string $uid;
    private string $bname;
    private string $bdesc;
    private int $author;
    private int $language;
    private int $publisher;
    private int $category;
    private $cover;
    private string $price;
    private string $eprice;
    private string $page;
    private string $subject;
    private string $about;
    private $locations;
    private $details;

    public function __construct($param)
    {
        $this->uid = (string) $_SERVER['HTTP_SOPNOLIKHI'];
        $this->bname = (string) $param['name'];
        $this->bdesc = (string) $param['description'];
        $this->author = (int) $param['author'];
        $this->language = (int) $param['language'];
        $this->publisher = (int) $param['publisher'];
        $this->category = (int) $param['category'];
        $this->cover = $_FILES['cover'];
        $this->price = (string) $param['price'];
        $this->eprice = (string) $param['eprice'];
        $this->page = (string) $param['page'];
        $this->subject = (string) $param['subject'];
        $this->about = (string) $param['about'];
        $this->locations = $param['locations'];
        $this->details = $param['device-info'];
    }

    public function createNewBook(): string
    {
        return $this->createBookRequst($this->createArray());
    }

    private function createArray(): array
    {
        $this->details['ip-address'] = $_SERVER['REMOTE_ADDR'] ?? null;

        return array(
            'uid' => $this->uid,
            'name' => $this->bname,
            'description' => $this->bdesc,
            'author' => $this->author,
            'language' => $this->language,
            'publisher' => $this->publisher,
            'category' => $this->category,
            'cover' => $this->cover,
            'price' => $this->price,
            'eprice' => $this->eprice,
            'page' => $this->page,
            'subject' => $this->subject,
            'about' => $this->about,
            'locations' => $this->locations,
            'device-info' => $this->details,
        );
    }
}