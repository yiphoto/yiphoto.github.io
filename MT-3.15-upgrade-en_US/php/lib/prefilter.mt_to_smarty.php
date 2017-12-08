<?php
/* Movable Type template -> Smarty template
  
    <$MTVariable$> -> {Variable}
  
    <MTVariable> -> {Variable}
  
    <MTVariable this="that"> -> {Variable this="that"}
  
    <MTVariable dirify="1"> -> {Variable|dirify:"1"}
  
    <MTEntries>...</MTEntries> -> {Entries}...{/Entries}
  
    <MTIfNonEmpty var="MTVariable">
      ...
    <MTElse>...</MTElse>
    </MTIfNonEmpty>
 -> {IfNonEmpty var="MTVariable"}{if $conditional}
      ...
    {/if}{if !$conditional}...{/if}{if $conditional}
    {/if}{/IfNonEmpty}

Note that all MT 'variable' tags are translated to functions.
This is necessary since you can't preload all the data that a
MT template may require. This is equivalent to the MT::Template::Context
approach-- every 'Variable' tag invokes a handler function.

The "Else" tag was a tricky beast. Ironic since I added that
syntax to MT myself. Here's how I decided to implement it. Each
'conditional' tag is handled a little differently than regular
block tags. They have a requirement to set a 'conditional' template
variable to 1 or 0 depending on whether the condition is met or not.
The setting for 'conditional' must be preserved and restored using
the 'localize' and 'restore' routines. Regardless of the value of
$conditional, the block function must return $content either way.
This allows the inner 'if' statements to do their work. See above
for how the '$conditional' variable is used.
*/
function smarty_prefilter_mt_to_smarty($tpl_source, &$ctx2) {
    global $mt;
    $ctx =& $mt->context();
    $ldelim = $ctx->left_delimiter;
    $rdelim = $ctx->right_delimiter;
    $smart_source = '';
    $tokenstack = array();

    if ($parts = preg_split('!(<(?:\$?|/)MT(?:.+?)(?:\$?|/)>)!s', $tpl_source, -1,
                       PREG_SPLIT_DELIM_CAPTURE)) {
        foreach ($parts as $part) {
            if (!preg_match('!<(\$?|/)(MT.+?)(\$?|/)>!s', $part, $matches)) {
                $smart_source .= $part;
                continue;
            }

            list($wholetag, $open, $tag, $close) = $matches;

            $attrargs = '';
            $modargs = '';

            list($mttag, $args) = preg_split('!\s+!s', $tag, 2);
            $mttag or $mttag = $tag;
            $attrs = array();

            if (preg_match_all('!(\w+)\s*=\s*(["\'])(.*?)?\2((?:\:(["\'])(.*?)?\5)*)?!s', $args,
                               $arglist, PREG_SET_ORDER)) {
                for ($a = 0; $a < count($arglist); $a++) {
                    $attr = $arglist[$a][1];
                    $attrs[$attr] = $arglist[$a][3];
                    if ($ctx->global_attr[$attr]) {
                        $modargs .= '|';
                        if ($ctx->global_attr[$arglist[$a][1]] != '1') {
                            $modargs .= $ctx->global_attr[$arglist[$a][1]];
                        } else {
                            $modargs .= $arglist[$a][1];
                        }
                        $modargs .= ':' . $arglist[$a][2] . $arglist[$a][3] . $arglist[$a][2];
                        if (isset($arglist[$a][4])) {
                           $modargs .= $arglist[$a][4];
                        }
                    } else {
                        $attrargs .= ' '.$arglist[$a][0];
                    }
                }
            }
            if (isset($ctx->sanitized[$mttag])) {
                if (!isset($attrs['sanitize'])) {
                    $modargs .= '|sanitize:"1"';
                }
            }

            if (preg_match('!^MTIf!', $mttag) ||
                preg_match('![a-z]If[A-Z]!', $mttag) ||
                isset($ctx->conditionals[$mttag])) {
                $conditional = 1;
            } else {
                $conditional = 0;
            }

            // force the elements in $vars to always to act like a function
            if ($open == '$') {
                $open = '';
            }

            if ((($open == '/' && $conditional) ||
                 ($mttag == 'MTElse')) &&
                $close != '/') {
                $smart_source .= $ldelim.'/if'.$rdelim;
            }

            $tokname = null;
            if (isset($ctx->needs_tokens[$mttag])) {
                if ($open != '/') {
                    $tokname = uniqid($mttag);
                    $attrargs .= ' token_fn="smarty_fun_'.$tokname.'"';
                    array_push($tokenstack, $tokname);
                } else {
                    $tokname = array_pop($tokenstack);
                    $smart_source .= $ldelim.'/defun'.$rdelim;#.$ldelim.'fun name="'.$tokname.'"'.$rdelim;
                }
            }

            $smart_source .= $ldelim.$open.
                                  $mttag.
                                  $modargs.
                                  $attrargs.
                                  $rdelim;

            if (isset($tokname)) {
                if ($open != '/') {
                    $smart_source .= $ldelim.'defun name="'.$tokname.'"'.$rdelim;
                }
            }

            if ($mttag == 'MTElse') {
                if ($open != '/') {
                    $smart_source .= $ldelim.'if !$conditional'.$rdelim;
                } else {
                    $smart_source .= $ldelim.'if $conditional'.$rdelim;
                }
            } elseif ($open != '/' && $conditional && $close != '/') {
                $smart_source .= $ldelim.'if $conditional'.$rdelim;
            } elseif ($close == '/') {
                $smart_source .= $ldelim.'/'.$mttag.$rdelim;
            }
        }
    } else {
        $smart_source = $tpl_source;
    }

    // allow normal php markers to work-- change them to
    // smarty php blocks...
    $smart_source = preg_replace('/<\?php(\s*.*?)\?>/s',
                                 $ldelim.'php'.$rdelim.'\1'.$ldelim.'/php'.$rdelim, $smart_source);
    return $smart_source;
}
?>
