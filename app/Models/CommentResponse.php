<?php


namespace App\Models;


class CommentResponse
{

    public $comment;
    public $owner;


    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }


    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

}
