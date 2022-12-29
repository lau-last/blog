<?php

class Post
{
    public $id;
    public $name;
    public $content;
    public $created;

    public function __construct()
    {
        if(is_int($this->created) || is_string($this->created)){
            $this->created = new DateTime('@' . $this->created);
        }
    }

    public function getExcerpt(): string
    {
        return substr($this->content, 0,150);
    }

}