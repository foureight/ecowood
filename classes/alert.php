<?php

class Alert
{
    public $id;
    public $text = '';
    public $od = '';
    public $do = '';

    public function get()
    {
        $alerts = json_decode(file_get_contents(__DIR__ . '/../data/alerts.json'), true);
        foreach ($alerts as $row) {
            if ((int) $row['id'] === (int) $this->id) {
                $this->text = $row['text'] ?? '';
                $this->od = $row['od'] ?? '';
                $this->do = $row['do'] ?? '';
                break;
            }
        }
        return $this;
    }
}
