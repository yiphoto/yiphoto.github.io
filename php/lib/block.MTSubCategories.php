<?php
function smarty_block_MTSubCategories($args, $content, &$ctx, &$repeat) {
    $localvars = array('subCatTokens', 'subCatsSortOrder', 'subCatsSortMethod', '_categories', 'inside_mt_categories', '_subcats_counter', 'entries', 'subCatIsFirst', 'subCatIsLast', 'category','current_archive_type');
    if (!isset($content)) {
        $ctx->localize($localvars);
        $token_fn = $args['token_fn'];

        $blog_id = $ctx->stash('blog_id');

        # Do we want the current category?
        $include_current = $args['include_current'];

        # Sorting information#   sort_order ::= 'ascend' | 'descend'
        #   sort_method ::= method name (e.g. package::method)
        #
        # sort_method takes precedence
        $sort_order = $args['sort_order'] or 'ascend';
        $sort_method = $args['sort_method'];

        # Store the tokens for recursion
        $ctx->stash('subCatTokens', $token_fn);
        $ctx->stash('current_archive_type', 'Category');

        # If we find ourselves in a category context 
        $current_cat = $ctx->stash('category') or
            $ctx->stash('archive_category');
        if ($current_cat) {
            if ($include_current) {
                # If we're to include it, just use it to seed the category list
                $cats = array($current_cat);
            } else {
                # Otherwise, use its children
                $cats = $ctx->mt->db->fetch_categories(array('blog_id' => $blog_id, 'category_id' => $current_cat['category_id'], 'children' => 1, 'show_empty' => 1));
            }
        } else {
            # Otherwise, use the top level categories
            $cats = $ctx->mt->db->fetch_categories(array('blog_id' => $blog_id, 'top_level_categories' => 1, 'show_empty' => 1));
        }

#        $cats = _sort_cats($ctx, $sort_method, $sort_order, $cats);
        if (!$cats) {
            $repeat = false;
            return '';
        }

        $ctx->stash('_categories', $cats);
        # Be sure the regular MT tags know we're in a category context
        $ctx->stash('inside_mt_categories', 1);
        $ctx->stash('subCatsSortOrder', $sort_order);
        $ctx->stash('subCatsSortMethod', $sort_method);
        $ctx->stash('_subcats_counter', 0);
        $count = 0;
    } else {
        # Init variables
        $cats = $ctx->stash('_categories');
        $count = $ctx->stash('_subcats_counter');
    }

    # Loop through the immediate children (or the current cat,
    # depending on the arguments
    if ($count < count($cats)) {
        $category = $cats[$count];
        $ctx->stash('category', $category);
        $ctx->stash('entries', null);
        $ctx->stash('subCatIsFirst', $count == 0);
        $ctx->stash('subCatIsLast', $count == (count($cats) - 1));
        $ctx->stash('_subcats_counter', $count + 1);
        $repeat = true;
    } else {
        $ctx->restore($localvars);
        $repeat = false;
    }
    return $content;
}
?>
