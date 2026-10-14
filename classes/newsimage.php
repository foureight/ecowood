<?php

class NewsImage
{
    public $urlname = '';

    public static function get_all($document_id)
    {
        $items = json_decode(file_get_contents(__DIR__ . '/../data/news.json'), true);
        $images = [];

        foreach ($items as $row) {
            if ((int) $row['id'] !== (int) $document_id) {
                continue;
            }
            foreach ($row['images'] ?? [] as $urlname) {
                $img = new self();
                $img->urlname = $urlname;
                $images[] = $img;
            }
        }

        return $images;
    }
}
