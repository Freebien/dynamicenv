<?php

class Post {
    public int $id;
    public string $title;
    public string $content;
    public int $date;
    
    public User $user;

    public function __construct(int $id, User $user, string $title, string $content, ?int $date=null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        if (!$date) $date = time();
        $this->date = $date;
        $this->user = $user;
    }
}