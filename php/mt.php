<?php
# Copyright 2001-2004 Six Apart. This code cannot be redistributed without
# permission from www.movabletype.org.
#
# $Id: mt.php,v 1.19 2004/10/01 00:22:45 bchoate Exp $

define('VERSION', '3.11');

class MT {
    var $mime_types = array(
        '__default__' => 'text/html',
        'css' => 'text/css',
        'txt' => 'text/plain',
        'rdf' => 'text/xml',
        'rss' => 'text/xml',
        'xml' => 'text/xml',
    );
    var $blog_id;
    var $db;
    var $config;
    var $debugging = false;
    var $caching = false;
    var $conditional = false;
    var $log = array();
    var $id;
    var $request;
    var $http_error;

    /***
     * Constructor for MT class. Also declares a global variable
     * '$mt' and assigns itself to that. There can only be one
     * instance of this class.
     */
    function MT($blog_id = null, $cfg_file = null) {
        global $mt;
        if (isset($mt)) {
            die("Only one instance of the MT class can be created.");
        }
        $mt = $this;
        $this->id = md5(uniqid('MT',true));

        if (!isset($cfg_file)) {
            $mtdir = dirname(dirname(__FILE__));
            $cfg_file = $mtdir . DIRECTORY_SEPARATOR . "mt.cfg";
        }

        $this->configure($cfg_file);
        if (isset($blog_id)) {
            $this->blog_id = $blog_id;
        }
    }

    function init_plugins() {
        $plugin_dir = $this->config['PHPDir'] . DIRECTORY_SEPARATOR . 'plugins';
        $ctx =& $this->context();
        // global filters have to be handled differently from
        // tag attributes, so this causes them to be recognized
        // as they should...
        if (is_dir($plugin_dir)) {
            if ($dh = opendir($plugin_dir)) {
                 while (($file = readdir($dh)) !== false) {
                     if (preg_match('/^modifier\.(.+?)\.php$/', $file, $matches)) {
                         $ctx->add_global_filter($matches[1]);
                     } elseif (preg_match('/^init\.(.+?)\.php$/', $file, $matches)) {
                         // load 'init' plugin file
                         require_once($file);
                     }
                 }
                 closedir($dh);
             }
        }
    }

    /***
     * Retreives a handle to the database and assigns it to
     * the member variable 'db'.
     */
    function &db() {
        if (isset($this->db)) return $this->db;

        require_once("mtdb_".$this->config['DBDriver'].".php");
        $mtdbclass = 'MTDatabase_'.$this->config['DBDriver'];
        $this->db = new $mtdbclass($this->config['DBUser'],
            $this->config['DBPassword'], $this->config['Database'],
            $this->config['DBHost']);
        return $this->db;
    }

    /***
     * Loads configuration data from mt.cfg and mt-db-pass.cgi files.
     * Stores content in the 'config' member variable.
     */
    function configure($file = null) {
        if (isset($this->config)) return $config;

        $cfg = array();
        if ($fp = file($file)) {
            foreach ($fp as $line) {
                // search through the file
                if (!ereg('^\s*\#',$line)) {
                    // ignore lines starting with the hash symbol
                    if (preg_match('/^\s*([^ ]+)[ ](.*)(\r|n)?$/', $line, $regs)) {
                        $key = trim($regs[1]);
                        $value = trim($regs[2]);
                        $cfg[$key] = $value;
                    }
                }
            }
        } else {
            die("Unable to open configuration file $file");
        }

        // setup directory locations
        // location of mt.php
        $cfg['PHPDir'] = realpath(dirname(__FILE__));
        // path to MT directory
        $cfg['MTDir'] = realpath(dirname($file));
        // path to handlers
        $cfg['PHPLibDir'] = $cfg['PHPDir'] . DIRECTORY_SEPARATOR . 'lib';

        // assign defaults:
        isset($cfg['StaticWebPath']) or
            $cfg['StaticWebPath'] = $cfg['CGIPath'];
        isset($cfg['PublishCharset']) or
            $cfg['PublishCharset'] = 'iso-8859-1';
        isset($cfg['TrackbackScript']) or
            $cfg['TrackbackScript'] = 'mt-tb.cgi';
        isset($cfg['CommentScript']) or
            $cfg['CommentScript'] = 'mt-comments.cgi';
        isset($cfg['XMLRPCScript']) or
            $cfg['XMLRPCScript'] = 'mt-xmlrpc.cgi';
        isset($cfg['SearchScript']) or
            $cfg['SearchScript'] = 'mt-search.cgi';
        isset($cfg['DefaultLanguage']) or
            $cfg['DefaultLanguage'] = 'en_us';
        isset($cfg['GlobalSanitizeSpec']) or
            $cfg['GlobalSanitizeSpec'] = 'a href,b,i,br/,p,strong,em,ul,ol,blockquote,pre';
        isset($cfg['CGIPath']) or
            $cfg['CGIPath'] = 'cgi-bin';
        isset($cfg['SignOnURL']) or
            $cfg['SignOnURL'] = 'https://www.typekey.com/t/typekey/login?';
        isset($cfg['SignOffURL']) or
            $cfg['SignOffURL'] = 'https://www.typekey.com/t/typekey/logout?';
        isset($cfg['IdentityURL']) or
            $cfg['IdentityURL'] = 'http://profile.typekey.com/';
    
        $cfg['DBHost'] or $cfg['DBHost'] = 'localhost'; // default to localhost
        $driver = $cfg['ObjectDriver'];
        $driver = preg_replace('/^DBI::/', '', $driver);
        $driver or $driver = 'mysql';
        $cfg['DBDriver'] = $driver;
    
        if ((strlen($cfg['Database'])<1 || strlen($cfg['DBUser'])<1)) {
            die("Unable to read database or username");
        }
    
        // read in the database password
        $password = implode('', file($cfg['MTDir'] . DIRECTORY_SEPARATOR . 'mt-db-pass.cgi'));
        $password = trim($password, "\n\r\0");
        $cfg['DBPassword'] = $password;

        // set up include path
        // add MT-PHP 'plugins' and 'lib' directories to the front
        // of the existing PHP include path:
        if (strtoupper(substr(PHP_OS, 0,3) == 'WIN')) {
            $path_sep = ';';
        } else {
            $path_sep = ':';
        }
        ini_set('include_path',
            $cfg['PHPDir'] . DIRECTORY_SEPARATOR . "plugins" . $path_sep .
            $cfg['PHPDir'] . DIRECTORY_SEPARATOR . "lib" . $path_sep .
            $cfg['PHPDir'] . DIRECTORY_SEPARATOR . "extlib" . $path_sep .
            $cfg['PHPDir'] . DIRECTORY_SEPARATOR . "extlib" . DIRECTORY_SEPARATOR . "smarty" . $path_sep .
            ini_get('include_path')
        );
    
        $this->config =& $cfg;
    }

    function configure_paths($blog_site_path) {
        if (preg_match('/^\./', $blog_site_path)) {
            // relative address, so tack on the MT dir in front
            $blog_site_path = $this->config['MTDir'] .
                DIRECTORY_SEPARATOR . $blog_site_path;
        }
        $this->config['PHPTemplateDir'] or
            $this->config['PHPTemplateDir'] = $blog_site_path .
            DIRECTORY_SEPARATOR . 'templates';
        $this->config['PHPCacheDir'] or
            $this->config['PHPCacheDir'] = $blog_site_path .
            DIRECTORY_SEPARATOR . 'cache';

        $ctx =& $this->context();
        $ctx->template_dir = $this->config['PHPTemplateDir'];
        $ctx->compile_dir = $ctx->template_dir . '_c';
        $ctx->cache_dir = $this->config['PHPCacheDir'];
    }

    /***
     * Mainline handler function.
     */
    function view($blog_id = null) {
        if ($this->debugging) {
            require_once("MTUtil.php");
        }
        $blog_id or $blog_id = $this->blog_id;

        $ctx =& $this->context();
        $this->init_plugins();
        $ctx->caching = $this->caching;

        // Some defaults...
        $mtdb =& $this->db();
        $ctx->mt->db =& $mtdb;

        // Set up our customer error handler
        $oldreporting = error_reporting(E_ALL ^ E_NOTICE);
        set_error_handler(array(&$this, 'error_handler'));

        // User-specified request through request variable
        $path = $this->request;

        // Apache request
        if (!$path && $_SERVER['REQUEST_URI']) {
            $path = $_SERVER['REQUEST_URI'];
            // strip off any query string...
            $path = preg_replace('/\?.*/', '', $path);
            // strip any duplicated slashes...
            $path = preg_replace('!/+!', '/', $path);
        }

        // IIS request by error document...
        if (!$path && (preg_match('/IIS/', $_SERVER['SERVER_SOFTWARE']))) {
            // assume 404 handler
            if (preg_match('/^\d+;(.*)$/', $_SERVER['QUERY_STRING'], $matches)) {
                $path = $matches[1];
                $path = preg_replace('!^http://[^/]+!', '', $path);
                if (preg_match('/\?(.+)?/', $path, $matches)) {
                    $_SERVER['QUERY_STRING'] = $matches[1];
                    $path = preg_replace('/\?.*$/', '', $path);
                }
            }
        }

        // now set the path so it may be queried
        $this->request = $path;

        // When we are invoked as an ErrorDocument, the parameters are
        // in the environment variables REDIRECT_*
        if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            // todo: populate $_GET and QUERY_STRING with REDIRECT_QUERY_STRING
            $_SERVER['QUERY_STRING'] = getenv('REDIRECT_QUERY_STRING');
        }

        if (preg_match('/\.(\w+)$/', $path, $matches)) {
            $req_ext = strtolower($matches[1]);
        }

        $this->blog_id = $blog_id;

        $data =& $this->resolve_url($path);
        if (!$data) {
            // 404!
            $this->http_error = 404;
            header("HTTP/1.1 404 Not found");
            header("Status: 404");
            return $ctx->error("Page not found - $path", E_USER_ERROR);
        }

        $info =& $data['fileinfo'];
        $fid = $info['fileinfo_id'];
        $at = $info['fileinfo_archive_type'];
        $ts = $info['fileinfo_startdate'];
        $tpl_id = $info['fileinfo_template_id'];
        $cat = $info['fileinfo_category_id'];
        $entry_id = $info['fileinfo_entry_id'];
        $blog_id = $info['fileinfo_blog_id'];
        $blog =& $data['blog'];
        if ($at == 'index') {
            $at = null;
        }
        $tts = $data['template']['template_modified_on'];
        $tts = offset_time(datetime_to_timestamp($tts), $blog);
        $ctx->stash('template_timestamp', $tts);

        $this->configure_paths($blog['blog_site_path']);

        // start populating our stash
        $ctx->stash('blog_id', $blog_id);
        $ctx->stash('blog', $blog);
        if ($cat) {
            $ctx->stash('category', $mtdb->fetch_category($cat));
        }
        //$ctx->last_ts($info['template_modified_on']);

        // conditional get support...
        if ($this->caching) {
            $this->cache_modified_check = true;
        }
        if ($this->conditional) {
            $last_ts = $blog['blog_children_modified_on'];
            $last_modified = $ctx->_hdlr_date(array('ts' => $last_ts, 'format' => '%a, %d %b %Y %H:%M:%S GMT', 'language' => 'en', 'utc' => 1), $ctx);
            $this->doConditionalGet($last_modified);
        }

        $cache_id = $blog_id.';'.$path;
        if (isset($ts)) {
            require_once("MTUtil.php");
            if ($at == 'Yearly') {
                $ts = substr($ts, 0, 4);
            } elseif ($at == 'Monthly') {
                $ts = substr($ts, 0, 6);
            } elseif ($at == 'Daily') {
                $ts = substr($ts, 0, 8);
            }
            if ($at == 'Weekly') {
                list($ts_start, $ts_end) = start_end_week($ts);
            } else {
                list($ts_start, $ts_end) = start_end_ts($ts);
            }
            $ctx->stash('current_timestamp', $ts_start);
            $ctx->stash('current_timestamp_end', $ts_end);
        }
        if (isset($at)) {
            $ctx->stash('current_archive_type', $at);
        }
    
        if (!$ctx->is_cached('mt:'.$tpl_id, $cache_id)) {
            if (isset($entry_id) && ($entry_id) && ($at == 'Individual')) {
                $entry =& $mtdb->fetch_entry($entry_id);
                $ctx->stash('entry', $entry);
                $ctx->stash('current_timestamp', $entry['entry_created_on']);
            }
        }

        $this->http_error = 200;
        header("HTTP/1.1 200 OK");
        header("Status: 200");
        // content-type header-- need to supplement with charset
        $content_type = $this->mime_types['__default__'];
        if ($req_ext && (isset($this->mime_types[$req_ext]))) {
            $content_type = $this->mime_types[$req_ext];
        }
        if (isset($config['PublishCharset'])) {
            $content_type .= '; charset=' . $config['PublishCharset'];
        }
        header("Content-Type: $content_type");

        $output = $ctx->fetch('mt:'.$tpl_id, $cache_id);

        //$last_ts = $ctx->last_ts();

        if ($this->debugging) {
            $this->log("Queries: ".$mtdb->num_queries);
            $this->log("Queries executed:");
            $queries = $mtdb->savedqueries;
            foreach ($queries as $q) {
                $this->log($q);
            }
            $this->log_dump();
        }
        restore_error_handler();
        error_reporting($oldreporting);

        // finally, issue output
        echo $output;
    }

    function &resolve_url($path) {
        $data =& $this->db->resolve_url($path, $this->blog_id);
        return $data;
    }

    function doConditionalGet($last_modified) {
        // Thanks to Simon Willison...
        //   http://simon.incutio.com/archive/2003/04/23/conditionalGet
        // A PHP implementation of conditional get, see 
        //   http://fishbowl.pastiche.org/archives/001132.html
        $etag = '"'.md5($last_modified).'"';
        // Send the headers
        header("Last-Modified: $last_modified");
        header("ETag: $etag");
        // See if the client has provided the required headers
        $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
            stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
            false;
        $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
            stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
            false;
        if (!$if_modified_since && !$if_none_match) {
            return;
        }
        // At least one of the headers is there - check them
        if ($if_none_match && $if_none_match != $etag) {
            return; // etag is there but doesn't match
        }
        if ($if_modified_since && $if_modified_since != $last_modified) {
            return; // if-modified-since is there but doesn't match
        }
        // Nothing has changed since their last request - serve a 304 and exit
        header('HTTP/1.1 304 Not Modified');
        exit;
    }

    function display($tpl, $cid = null) {
        $ctx =& $this->context();
        $this->init_plugins();
        $blog =& $ctx->stash('blog');
        if (!$blog) {
            $db =& $this->db();
            $ctx->mt->db =& $db;
            $blog =& $db->fetch_blog($this->blog_id);
            $ctx->stash('blog', $blog);
            $ctx->stash('blog_id', $this->blog_id);
            $this->configure_paths($blog['blog_site_path']);
        }
        return $ctx->display($tpl, $cid);
    }

    function fetch($tpl, $cid = null) {
        $ctx =& $this->context();
        $this->init_plugins();
        $blog =& $ctx->stash('blog');
        if (!$blog) {
            $db =& $this->db();
            $ctx->mt->db =& $db;
            $blog =& $db->fetch_blog($this->blog_id);
            $ctx->stash('blog', $blog);
            $ctx->stash('blog_id', $this->blog_id);
            $this->configure_paths($blog['blog_site_path']);
        }
        return $ctx->fetch($tpl, $cid);
    }

    function log_dump() {
        if ($_SERVER['REMOTE_ADDR']) {
            // web view...
            echo "<div class=\"debug\" style=\"border:1px solid red; margin:0.5em; padding: 0 1em; text-align:left; background-color:#ddd; color:#000\"><pre>";
            echo implode("\n", $this->log);
            echo "</pre></div>\n\n";
        } else {
            // console view...
            $stderr = fopen('php://stderr', 'w'); 
            fwrite($stderr,implode("\n", $this->log)); 
            echo (implode("\n", $this->log)); 
            fclose($stderr);
        }
    }

    function error_handler($errno, $errstr, $errfile, $errline) {
        if ($errno & (E_ALL ^ E_NOTICE)) {
            $mtphpdir = $this->config['PHPDir'];
            $ctx =& $this->context();
            $ctx->stash('blog_id', $this->blog_id);
            $ctx->stash('error_message', $errstr."<!-- file: $errfile; line: $errline; code: $errno -->");
            $ctx->stash('error_code', $errno);
            $http_error = $this->http_error;
            if (!$http_error) {
                $http_error = 500;
            }
            $ctx->stash('http_error', $http_error);
            $ctx->stash('error_file', $errfile);
            $ctx->stash('error_line', $errline);
            $ctx->template_dir = $mtphpdir . DIRECTORY_SEPARATOR . 'tmpl';
            $ctx->caching = 0;
            $ctx->stash('StaticWebPath', $this->config['StaticWebPath']);
            $ctx->stash('PublishCharset', $this->config['PublishCharset']);
            $charset = $this->config['PublishCharset'];
            $out = $ctx->tag('Include', array('type' => 'dynamic_error'));
            if (isset($out)) {
                header("Content-type: text/html; charset=".$charset);
                echo $out;
            } else {
                header("HTTP/1.1 500 Server Error");
                header("Content-type: text/plain");
                echo "Error executing error template.";
            }
            exit;
        }
    }

    /***
     * Retreives a context and rendering object.
     */
    function &context() {
        static $ctx;
        if (isset($ctx)) return $ctx;

        require_once('MTViewer.php');
        $ctx = new MTViewer($this);
        $ctx->mt =& $this;
        $mtphpdir = $this->config['PHPDir'];
        $mtlibdir = $this->config['PHPLibDir'];
        $ctx->compile_check = 1;
        $ctx->caching = false;
        $ctx->plugins_dir[] = $mtlibdir;
        $ctx->plugins_dir[] = $mtphpdir . DIRECTORY_SEPARATOR . "plugins";
        if ($this->debugging) {
            $ctx->debugging_ctrl = 'URL';
            $ctx->debug_tpl = $mtphpdir . DIRECTORY_SEPARATOR .
                'extlib' . DIRECTORY_SEPARATOR .
                'smarty' . DIRECTORY_SEPARATOR .
                'debug.tpl';
        }
        if (isset($this->config['SafeMode']) && ($this->config['SafeMode'])) {
            // disable PHP support
            $ctx->php_handling = SMARTY_PHP_REMOVE;
        }
        return $ctx;
    }

    function log($msg = null) {
        $this->log[] = $msg;
    }

    function translate_templatized_item($str) {
        // todo: run through translation layer
        return $str[1];
    }

    function translate_templatized($tmpl) {
        $cb = array($this, 'translate_templatized_item');
        $out = preg_replace_callback('/<MT_TRANS phrase="(.+?)">/', $cb, $tmpl);
        return $out;
    }
}

function is_valid_email($addr) {
    if (preg_match('/[ |\t|\r|\n]*\"?([^\"]+\"?@[^ <>\t]+\.[^ <>\t][^ <>\t]+)[ |\t|\r|\n]*/', $addr, $matches)) {
        return $matches[1];
    } else {
        return 0;
    }
}

$spam_protect_map = array(':' => '&#58;', '@' => '&#64;', '.' => '&#46;');
function spam_protect($str) {
    global $spam_protect_map;
    return strtr($str, $spam_protect_map);
}

function datetime_to_timestamp($dt) {
    $dt = preg_replace('/[^0-9]/', '', $dt);
    $ts = mktime(substr($dt, 8, 2), substr($dt, 10, 2), substr($dt, 12, 2), substr($dt, 4, 2), substr($dt, 6, 2), substr($dt, 0, 4));
    return $ts;
}

function offset_time($ts, $blog = null, $dir = null) {
    if (isset($blog)) {
        if (!is_array($blog)) {
            global $mt;
            $blog = $mt->db->fetch_blog($blog);
        }
        $offset = $blog['blog_server_offset'];
    } else {
        global $mt;
        $offset = $mt->config['TimeOffset'];
    }
    intval($offset) or $offset = 0;
    $tsa = localtime($ts);

    if ($tsa[8]) {  // daylight savings offset
        $offset++;
    }
    if ($dir == '-') {
        $offset *= -1;
    }
    $ts += $offset * 3600;
    return $ts;
}
?>
