<?php
function smarty_modifier_encode_html($text) {
    return htmlentities($text, ENT_COMPAT);
}
?>
