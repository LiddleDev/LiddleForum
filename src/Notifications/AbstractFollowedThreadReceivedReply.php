<?php

namespace LiddleDev\LiddleForum\Notifications;

use Illuminate\Notifications\Notification;
use LiddleDev\LiddleForum\Models\Post;
use LiddleDev\LiddleForum\Models\Thread;

abstract class AbstractFollowedThreadReceivedReply extends Notification
{
    /**
     * @var Thread
     */
    protected $thread;

    /**
     * @var Post
     */
    protected $post;

    /**
     * Create a new notification instance.
     *
     * @param Thread $thread
     * @param Post $post
     */
    final public function __construct(Thread $thread, Post $post)
    {
        $this->thread = $thread;
        $this->post = $post;
    }
}
