<?php
function smarty_function_MTCommentBody($args, &$ctx) {
    $comment = $ctx->stash('comment');
    $text = $comment['comment_text'];

    $blog = $ctx->stash('blog');
    $cb = $blog['blog_convert_paras_comments'];
    if ($cb == '1' || $cb == '__default__') {
        $cb = 'convert_breaks';
    }
    $ctx->load_modifier($cb);
    $mod = 'smarty_modifier_'.$cb;
  
    $text = $mod($text);

    return $text;
}
?>
