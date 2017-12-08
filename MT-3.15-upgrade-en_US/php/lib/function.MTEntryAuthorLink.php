<?php
function smarty_function_MTEntryAuthorLink($args, &$ctx) {
    $entry = $ctx->stash('entry');
    $name = $entry['author_name'];
    $show_email = 1;
    $show_url = 1;
    if (isset($args['show_email']) && !$args['show_email'])
        $show_email = 0;
    if (isset($args['show_url']) && !$args['show_url'])
        $show_url = 0;
    if ($show_url && $entry['author_url']) {
        return sprintf("<a target=\"_blank\" href=\"%s\">%s</a>", $entry['author_url'], $name);
    } elseif ($show_email && $entry['author_email']) {
        $str = 'mailto:' . $entry['author_email'];
        if (isset($args['spam_protect']) && $args['spam_protect']) {
            $str = spam_protect($str);
        }
        return sprintf("<a href=\"%s\">%s</a>", $str, $name);
    } else {
        return $name;
    }
}
?>
