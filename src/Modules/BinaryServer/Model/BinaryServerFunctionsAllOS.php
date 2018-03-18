<?php

Namespace Model;

class BinaryServerFunctionsAllOS extends Base {

    // Compatibility
    public $os = array("any") ;
    public $linuxType = array("any") ;
    public $distros = array("any") ;
    public $versions = array("any") ;
    public $architectures = array("any") ;

    // Model Group
    public $modelGroup = array("ServerFunctions") ;

    /* The following code has been ported from Binary source <http://binary-scm.com>
       by Jon Lund Steffensen, July 2011. Licenced under GPL2. */

    public function str_endswith($s, $test) {
        $strlen = strlen($s);
        $testlen = strlen($test);
        if ($testlen > $strlen) return FALSE;
        return substr_compare($s, $test, -$testlen) === 0;
    }

    public function header_nocache() {
        header('Expires: Fri, 01 Jan 1980 00:00:00 GMT');
        header('Pragma: no-cache');
        header('Cache-Control: no-cache, max-age=0, must-revalidate');
    }

    public function header_cache_forever() {
        header('Expires: '.date('r', time() + 31536000));
        header('Cache-Control: public, max-age=31536000');
    }

    public function send_local_file($type, $path) {
        $f = @fopen($path, 'rb');
        if (!$f) {
            header('Status: 404 Not Found');
            die();
        }

        $stat = fstat($f);
        header('Content-Type: '.$type);
        header('Last-Modified: '.date('r', $stat['mtime']));

        fpassthru($f);
        fclose($f);
    }

    public function get_text_file($binary_path, $name) {
        header_nocache();
        send_local_file('text/plain', $binary_path.$name);
    }

    public function get_loose_object($binary_path, $name) {
        header_cache_forever();
        send_local_file('application/x-binary-loose-object', $binary_path.$name);
    }

    public function get_pack_file($binary_path, $name) {
        header_cache_forever();
        send_local_file('application/x-binary-packed-objects', $binary_path.$name);
    }

    public function get_idx_file($binary_path, $name) {
        header_cache_forever();
        send_local_file('application/x-binary-packed-objects-toc', $binary_path.$name);
    }


    public function ref_entry_cmp($a, $b) {
        return strcmp($a[0], $b[0]);
    }

    public function read_packed_refs($f) {
        $list = array();

        while (($line = fgets($f)) !== FALSE) {
            if (preg_match('~^([0-9a-f]{40})\s(\S+)~', $line, $matches)) {
                $list[] = array($matches[2], $matches[1]);
            }
        }

        usort($list, 'ref_entry_cmp');
        return $list;
    }

    public function get_packed_refs($binary_path) {
        $packed_refs_path = $binary_path.'/packed-refs';
        $f = @fopen($packed_refs_path, 'r');

        $list = array();

        if ($f) {
            $list = read_packed_refs($f);
            fclose($f);
        }

        return $list;
    }

    public function resolve_ref($binary_path, $ref) {
        $depth = 5;

        while (TRUE) {
            $depth -= 1;
            if ($depth < 0) {
                return array(NULL, '0000000000000000000000000000000000000000');
            }

            $path = $binary_path.'/'.$ref;
            if (!@lstat($path)) {
                foreach (get_packed_refs($binary_path) as $pref) {
                    if (!strcmp($pref[0], $ref)) {
                        return array($ref, $pref[1]);
                    }
                }
                return array(NULL, '0000000000000000000000000000000000000000');
            }

            if (is_link($path)) {
                $dest = readlink($path);
                if (strlen($dest) >= 5 && !strcmp('refs/', substr($dest, 0, 5))) {
                    $ref = $dest;
                    continue;
                }
            }

            if (is_dir($path)) {
                return array(NULL, '0000000000000000000000000000000000000000');
            }

            $buffer = file_get_contents($path);
            if (!preg_match('~ref:\s*(.*)~', $buffer, $matches)) {
                if (strlen($buffer) < 40) {
                    return array(NULL, '0000000000000000000000000000000000000000');
                }

                return array($ref, substr($buffer, 0, 40));
            }

            $ref = $matches[1];
        }
    }

    public function get_ref_dir($binary_path, $base, $list=array()) {
        $path = $binary_path.'/'.$base;
        $dir = dir($path);

        while (($entry = $dir->read()) !== FALSE) {
            if ($entry[0] == '.') continue;
            if (strlen($entry) > 255) continue;
            if (str_endswith($entry, '.lock')) continue;

            $entry_path = $path.'/'.$entry;

            if (is_dir($entry_path)) {
                $list = get_ref_dir($binary_path, $base.'/'.$entry, $list);
            } else {
                $r = resolve_ref($binary_path, $base.'/'.$entry);
                $list[] = array($base.'/'.$entry, $r[1]);
            }
        }

        usort($list, 'ref_entry_cmp');
        return $list;
    }

    public function get_loose_refs($binary_path) {
        return get_ref_dir($binary_path, 'refs');
    }

    public function get_refs($binary_path) {
        $list = array_merge(get_loose_refs($binary_path), get_packed_refs($binary_path));
        usort($list, 'ref_entry_cmp');
        return $list;
    }

    public function get_info_refs($binary_path, $name) {
        header_nocache();
        header('Content-Type: text/plain');

        /* TODO Are dereferenced tags needed in this
           list, or just a convenience? */

        foreach (get_refs($binary_path) as $ref) {
            echo $ref[1]."\t".$ref[0]."\n";
        }
    }

    public function get_info_packs($binary_path, $name) {
        header_nocache();
        header('Content-Type: text/plain; charset=utf-8');

        $pack_dir = $binary_path.'/objects/pack';
        $dir = dir($pack_dir);

        while (($entry = $dir->read()) !== FALSE) {
            if (str_endswith($entry, '.idx')) {
                $name = substr($entry, 0, -4);
                if (is_file($pack_dir.'/'.$name.'.pack')) {
                    echo 'P '.$name.'.pack'."\n";
                }
            }
        }
    }

    public function serveBinary() {


        $services = array(
            array('GET', '/HEAD$', 'get_text_file'),
            array('GET', '/info/refs$', 'get_info_refs'),
            array('GET', '/objects/info/alternates$', 'get_text_file'),
            array('GET', '/objects/info/http-alternates$', 'get_text_file'),
            array('GET', '/objects/info/packs$', 'get_info_packs'),
            array('GET', '/objects/[0-9a-f]{2}/[0-9a-f]{38}$', 'get_loose_object'),
            array('GET', '/objects/pack/pack-[0-9a-f]{40}\\.pack$', 'get_pack_file'),
            array('GET', '/objects/pack/pack-[0-9a-f]{40}\\.idx$', 'get_idx_file'));


        /* Base url of this app */
        $url_base = '/php-binary-server';

        /* Repositories */
        $repos = array(
            array('/php-binary-server.binary', '.binary'),
            array('/wiki.binary', '/home/jon/Wiki/.binary'));

        $repos = array("ptbuild") ;

        foreach ($repos as $repo) {
            //if (preg_match('~^'.$url_base.$repo[0].'(/.*)~', $url_path, $matches)) {
            if ($repo == "ptbuild") {
                $repo_path = "ptbuild";
                $repo_location = "/opt/ptsource/repositories" ;


                foreach ($services as $service) {
                    if (preg_match('~^'.$service[1].'~', $repo_path)) {

                        if ($_SERVER['REQUEST_METHOD'] != $service[0]) {
                            header('Status: 405 Method Not Allowed');
                            header('Allow: '.$service[0]);
                            echo 'Method Not Allowed';
                            die();
                        }
                        //                call_user_func($service[2], $repo[1], $repo_path);
                        call_user_func($service[2], $repo_location, $repo_path);
                        die();
                    }
                }

                header('Status: 404 Not Found');
                die();
            }
        }

        header('Status: 404 Not Found');
        die();
    }



}