<?php


namespace App\Services\BankLv;


class Request
{
    public function getXml(): string
    {
        return file_get_contents(getenv('BANK_XML_LINK'));
    }
}
