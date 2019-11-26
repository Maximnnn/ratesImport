<?php


namespace App\Services\BankLv;
use DOMDocument;

class XmlParser
{
    private $xml;

    public function __construct(string $xml)
    {
        $this->xml = simplexml_load_string($xml);
    }

    public function parse(): array
    {
        return [
            'date' => $this->getDate(),
            'rates' => $this->getRates()
        ];
    }

    protected function getRates(): array
    {
        $ratesStr = '';

        $doc = new DOMDocument();
        $doc->loadXML($this->xml->channel->item->description->asXML());

        foreach ($doc->getElementsByTagName('description') as $children) {
            foreach ($children->childNodes as $node) {
                if ($node->nodeType == XML_CDATA_SECTION_NODE) {
                    $ratesStr .= $node->textContent;
                }
            }
        }

        return $this->parseRates($ratesStr);
    }

    protected function parseRates(string $rates): array
    {
        preg_match_all('/[a-zA-Z]{3} [0-9]{1,}[.][0-9]{1,}/', $rates, $matches);

        return array_map(function($match) {
            $tmp = explode(' ', $match);
            return [
                'currency' => $tmp[0],
                'rate'     => $tmp[1]
            ];
        }, $matches[0]);
    }

    protected function getDate(): \DateTime
    {
        return new \DateTime((string)$this->xml->channel->item->pubDate);
    }
}
