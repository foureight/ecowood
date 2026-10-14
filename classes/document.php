<?php

class Document
{
    public $id;
    public $title_cz = '';
    public $text_cz = '';

    public static function get_all()
    {
        $items = json_decode(file_get_contents(__DIR__ . '/../data/news.json'), true);
        $documents = [];

        foreach ($items as $row) {
            $doc = new self();
            $doc->id = $row['id'];
            $doc->title_cz = $row['title_cz'] ?? '';
            $doc->text_cz = $row['text_cz'] ?? '';
            $documents[] = $doc;
        }

        return $documents;
    }
}
