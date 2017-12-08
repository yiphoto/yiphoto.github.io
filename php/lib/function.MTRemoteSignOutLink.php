<?php
function smarty_function_MTRemoteSignOutLink($args, &$ctx) {
    // status: complete
    // parameters: none
    $entry = $ctx->stash('entry');
    return $ctx->mt->config['CGIPath'] . $ctx->mt->config['CommentScript'] .
        '?__mode=handle_sign_in&' .
        ($args['static'] ? 'static=1' : 'static=0') .
        '&entry_id=' . $entry['entry_id'] . '&logout=1';
}
?>
