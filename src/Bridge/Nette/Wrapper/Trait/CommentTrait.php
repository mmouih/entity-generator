<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

trait CommentTrait
{
    public function addComment(string $comment): void
    {
        $this->inner->addComment($comment);
    }
}
