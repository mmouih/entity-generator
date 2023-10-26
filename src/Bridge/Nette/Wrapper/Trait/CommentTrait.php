<?php

namespace EntityGenerator\Bridge\Nette\Wrapper\Trait;

/**
 * @author Mounir Mouih <mounir.mouih@gmail.com>
 */
trait CommentTrait
{
    public function addComment(string $comment): void
    {
        $this->inner->addComment($comment);
    }
}
