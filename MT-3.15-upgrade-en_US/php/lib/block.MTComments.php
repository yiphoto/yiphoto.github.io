<?php
function smarty_block_MTComments($args, $content, &$ctx, &$repeat) {
    $localvars = array('_comments', 'comment_order_num','comment','current_timestamp');
    if (!isset($content)) {
        $ctx->localize($localvars);
        $entry = $ctx->stash('entry');
        $args['entry_id'] = $entry['entry_id'];
        $comments = $ctx->mt->db->fetch_comments($args);
        $ctx->stash('_comments', $comments);
        $counter = 0;
    } else {
        $comments = $ctx->stash('_comments');
        $counter = $ctx->stash('comment_order_num');
    }
    if ($counter < count($comments)) {
        $comment = $comments[$counter];
        $ctx->stash('comment', $comment);
        $ctx->stash('current_timestamp', $comment['comment_created_on']);
        $ctx->stash('comment_order_num', $counter + 1);
        $repeat = true;
    } else {
        $ctx->restore($localvars);
        $repeat = false;
    }
    return $content;
}
?>
