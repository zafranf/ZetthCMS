<?php
if (!function_exists('_get_status_text')) {
    /**
     * Undocumented function
     *
     * @param integer $sts
     * @param array $par
     * @return void
     */
    function _get_status_text($sts = 0, $par = [])
    {
        /* check custom parameter */
        if (empty($par)) {
            $par = ['Nonaktif', 'Aktif'];
        }

        /* generate text */
        if ($sts == 0) {
            echo '<span class="bg-danger text-center" style="padding:2px 3px;">' . $par[0] . '</span>';
        } else {
            echo '<span class="bg-success text-center" style="padding:2px 3px;">' . $par[1] . '</span>';
        }
    }
}

if (!function_exists('_get_access_buttons')) {
    /**
     * Undocumented function
     *
     * @param string $url
     * @param string $btn
     * @return void
     */
    function _get_access_buttons($url = '', $btn = '')
    {
        /* ambil user login */
        $user = \Auth::user();
        if (!$user) {
            throw new \Exception('There are no user in current session');
        }

        /* ambil route name */
        $name = \Route::current()->getName();
        $xname = explode('.', $name);

        if ($btn == 'add') {
            if ($user->can('create-' . $xname[0])) {
                echo '<a href="' . url($url . '/create') . '" class="btn btn-primary" data-toggle="tooltip" data-original-title="Tambah Data"><i class="fe fe-plus-square"></i></a>';
            }
        } else {
            if ($user->can('read-' . $xname[0])) {
                echo "actions += '&nbsp;<a href=\"' + url + '\" class=\"btn btn-outline-success btn-sm\" data-toggle=\"tooltip\" data-original-title=\"Detail\"><i class=\"fe fe-eye\"></i></a>';";
            }
            if ($user->can('update-' . $xname[0])) {
                echo "actions += '&nbsp;<a href=\"' + url + '/edit\" class=\"btn btn-outline-warning btn-sm\" data-toggle=\"tooltip\" data-original-title=\"Edit\"><i class=\"fe fe-edit\"></i></a>';";
            }
            if ($user->can('delete-' . $xname[0])) {
                echo "actions += '&nbsp;<a href=\"#\" onclick=\"' + del + '\" class=\"btn btn-outline-danger btn-sm\" data-toggle=\"tooltip\" data-original-title=\"Hapus\"><i class=\"fe fe-trash-2\"></i></a>';";
            }
        }
    }
}

if (!function_exists('sequence')) {
    /**
     * Undocumented function
     *
     * @return void
     */
    function sequence()
    {
        \DB::statement(\DB::raw('set @rownum=0'));

        return \DB::raw('@rownum := @rownum + 1 AS no');
    }
}

if (!function_exists('debug')) {
    /**
     * Debugging variable
     *
     * @return void
     */
    function debug()
    {
        array_map(function ($data) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }, func_get_args());
        die();
    }
}

if (!function_exists('bool')) {
    /**
     * Convert string to boolean
     *
     * @param string $str
     * @return void
     */
    function bool($str = "")
    {
        if (is_string($str) || is_int($str)) {
            $str = strtolower(trim($str));
            if ($str == 'true' || $str == 't' || $str == 'yes' || $str == 'y' || $str == '1' || $str == 'on') {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('str_sanitize')) {
    /**
     * Sanitize string
     */
    function str_sanitize($string)
    {
        return trim(e($string));
    }
}

if (!function_exists('_cut_text')) {
    /**
     * Cut some text
     *
     * @param string $text
     * @param integer $start
     * @param integer $end
     * @param string $separator
     * @return void
     */
    function _cut_text($text, $start = 50, $end = 5, $separator = "...")
    {
        $min = $start + $end;
        if (strlen($text) > $min) {
            $head = substr($text, 0, $start);
            $tail = substr($text, -$end);
            $text = $head . $separator . $tail;
        }

        return $text;
    }
}

if (!function_exists('_get_image')) {
    /**
     * [_get_image description]
     * @param  string $path  [description]
     * @param  string $image [description]
     * @return [type]        [description]
     */
    function _get_image($image = "", $default = 'assets/images/no-image2.png')
    {
        $img = public_path($image);
        if (file_exists($img) && !is_dir($img)) {
            $img = url($image);
        } else {
            $img = url($default);
        }

        return $img;
    }
}

if (!function_exists('is_json')) {
    /**
     * Validate string to json
     *
     * @param string $data
     * @return boolean
     */
    function is_json($data = null)
    {
        if (!is_null($data)) {
            @json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }

        return false;
    }
}

if (!function_exists('_load_css')) {
    /**
     * [_load_css description]
     * @param  string $name [description]
     * @return [type]       [description]
     */
    function _load_css($file)
    {
        if (file_exists(public_path($file))) {
            $mtime = filemtime(public_path($file));

            return '<link href="' . url($file) . '?' . $mtime . '" rel="stylesheet">';
        }

        return null;
    }
}

if (!function_exists('_load_js')) {
    /**
     * [_load_js description]
     * @param  string $name [description]
     * @return [type]       [description]
     */
    function _load_js($file, $async = false)
    {
        if (file_exists(public_path($file))) {
            $mtime = filemtime(public_path($file));
            $async = ($async) ? ' async' : '';

            return '<script src="' . url($file) . '?' . $mtime . '"' . $async . '></script>';
        }

        return null;
    }
}

if (!function_exists('nf')) {
    /**
     * Alias for number_format
     *
     * @param integer $num
     * @param integer $digit
     * @param string $coms
     * @param string $dots
     * @return void
     */
    function nf($num, $digit = 0, $coms = ",", $dots = ".")
    {
        return number_format($num, $digit, $coms, $dots);
    }
}

if (!function_exists('upcase')) {
    /**
     * Alias for strtoupper
     *
     * @param string $str
     * @return void
     */
    function upcase($str = "")
    {
        return strtoupper($str);
    }
}

if (!function_exists('lowcase')) {
    /**
     * Alias for strtolower
     *
     * @param string $str
     * @return void
     */
    function lowcase($str = "")
    {
        return strtolower($str);
    }
}

if (!function_exists('_server')) {
    /**
     * Alias for $_SERVER
     *
     * @param string $key
     * @return void
     */
    function _server($key = null)
    {
        /* Check $key */
        if (is_null($key)) {
            return $_SERVER;
        }

        /* Check requested string */
        $key = upcase($key);
        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }
}

if (!function_exists('_session')) {
    /**
     * Alias for $_SESSION
     *
     * @param string $key
     * @return void
     */
    function _session($key = null)
    {
        /* Check $key */
        if (is_null($key)) {
            return $_SESSION;
        }

        /* Check requested string */
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }
}

if (!function_exists('_input')) {
    /**
     * Alias for $_REQUEST
     *
     * @param string $key
     * @param boolean $int
     * @return void
     */
    function _input($key = null, $int = false)
    {
        /* Check $key */
        if (is_null($key)) {
            return $_REQUEST;
        }

        /* Check requested string */
        if (isset($_REQUEST[$key])) {
            $val = $_REQUEST[$key];

            /* Make it as integer if true */
            if ($int) {
                return (int) $val;
            }

            return $val;
        }

        return null;
    }
}

if (!function_exists('_get')) {
    /**
     * Alias for $_GET
     *
     * @param string $key
     * @param boolean $int
     * @return void
     */
    function _get($key = null, $int = false)
    {
        /* Check $key */
        if (is_null($key)) {
            return $_GET;
        }

        /* Check requested string */
        if (isset($_GET[$key])) {
            $val = $_GET[$key];

            /* Make it as integer if true */
            if ($int) {
                return (int) $val;
            }

            return $val;
        }

        return null;
    }
}

if (!function_exists('_post')) {
    /**
     * Alias for $_POST
     *
     * @param string $key
     * @param boolean $int
     * @return void
     */
    function _post($key = null, $int = false)
    {
        /* Check $key */
        if (is_null($key)) {
            return $_POST;
        }

        /* Check requested string */
        if (isset($_POST[$key])) {
            $val = $_POST[$key];

            /* Make it as integer if true */
            if ($int) {
                return (int) $val;
            }

            return $val;
        }

        return null;
    }
}

if (!function_exists('_files')) {
    /**
     * Alias for $_FILES
     *
     * @param string $key
     * @return void
     */
    function _files($key = null)
    {
        /* rearrange files */
        $_FILES = rearrangeFiles();

        /* Check $key */
        if (is_null($key)) {
            return $_FILES;
        }

        /* Check requested string */
        if (isset($_FILES[$key])) {
            return _file($key);
        }

        return null;
    }
}

if (!function_exists('_file')) {
    /**
     * Get file detail in $_FILES
     *
     * @param string $name
     * @return void
     */
    function _file($name)
    {
        $fl = null;

        /* Check requested file */
        if (!is_array($name) && isset($_FILES[$name])) {
            $file = $_FILES[$name];
        }

        /* Mapping file */
        if (isset($file['name']) && $file['name'] != "" && $file['error'] == 0) {
            $xname = explode(".", $file['name']);
            $fl = [];
            $fl['filename'] = $file['name'];
            $fl['name'] = str_replace('.' . end($xname), "", $file['name']);
            $fl['ext'] = '.' . end($xname);
            $fl['tmp'] = $file['tmp_name'];
            $fl['size'] = $file['size'];
            $fl['mime'] = mime_content_type($fl['tmp']);

            /* Get image dimension */
            $mime = explode("/", $fl['mime'])[0];
            if ($mime == "image" || in_array($fl['ext'], ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'])) {
                $info = getimagesize($fl['tmp']);
                $fl['width'] = $info[0];
                $fl['height'] = $info[1];
            }
        }

        return $fl;
    }
}

if (!function_exists('rearrangeFiles')) {
    /**
     * Rearrange recursive $_FILES
     * http://php.net/manual/en/features.file-upload.multiple.php#118180
     *
     * @return void
     */
    function rearrangeFiles()
    {
        $walker = function ($files, $fileInfokey, callable $walker) {
            $ret = [];
            foreach ($files as $k => $v) {
                if (is_array($v)) {
                    $ret[$k] = $walker($v, $fileInfokey, $walker);
                } else {
                    $ret[$k][$fileInfokey] = $v;
                }
            }
            return $ret;
        };

        $files = [];
        foreach ($_FILES as $name => $values) {
            /* init for array_merge */
            if (!isset($files[$name])) {
                $files[$name] = [];
            }
            if (!is_array($values['error'])) {
                /* normal syntax */
                $files[$name] = $values;
            } else {
                /* html array feature */
                foreach ($values as $fileInfoKey => $subArray) {
                    $files[$name] = array_replace_recursive($files[$name], $walker($subArray, $fileInfoKey, $walker));
                }
            }
        }

        return $files;
    }
}

if (!function_exists('getMenu')) {
    function getMenu($group = 'admin')
    {
        $menus = [];
        $user = \Auth::user();

        $cacheRoleIdName = 'cache-roleid-user' . $user->id;
        $cacheRoleId = \Cache::get($cacheRoleIdName);
        if ($cacheRoleId) {
            $roles_id = $cacheRoleId;
        } else {
            $user = $user->load('role_ids');
            $roles_id = $user->role_ids->map(function ($arr) {
                return $arr->role_id;
            });

            \Cache::put($cacheRoleIdName, $roles_id, 10);
        }

        $cacheMenuName = 'cacheMenu-menu-user' . $user->id;
        $cacheMenu = \Cache::get($cacheMenuName);
        if ($cacheMenu) {
            $menus = $cacheMenu;
        } else {
            $roles = \App\Models\Role::with('menu.submenu')->whereIn('id', $roles_id)->get();

            foreach ($roles as $role) {
                if ($role->menu) {
                    foreach ($role->menu as $menu) {
                        if ($menu->group == $group) {
                            $menus[] = $menu;
                        }
                    }
                }
            }

            \Cache::put($cacheMenuName, $menus, 10);
        }

        return $menus;
    }
}

if (!function_exists('generateMenu')) {
    /**
     * Generate Top Menu
     *
     * @return void
     */
    function generateMenu($group = 'admin')
    {
        $menus = getMenu($group);

        echo '<ul class="navbar-nav">';
        foreach ($menus as $menu) {
            $href = !empty($menu->route_name) ? 'href="' . route($menu->route_name) . '"' : '';
            $sub = count($menu->submenu) ? ' dropdown' : '';
            $sublink = count($menu->submenu) ? ' dropdown-toggle' : '';
            $subtoggle = count($menu->submenu) ? ' data-toggle="dropdown"' : '';
            $icon = ($menu->icon != "") ? '<i class="' . $menu->icon . '"></i>' : '';
            echo '<li class="nav-item' . ($sub ?? '') . '">';
            echo '<a ' . ($href ?? '') . ' class="nav-link' . ($sublink ?? '') . '"' . ($subtoggle ?? '') . '>' . $icon . ' ' . $menu->name . '</a>';
            if (count($menu->submenu) > 0) {
                generateSubmenu($menu->submenu);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}

if (!function_exists('generateSubmenu')) {
    /**
     * Generate Top Submenu
     *
     * @return void
     */
    function generateSubmenu($data, $level = 0)
    {
        $sublevel = ($level > 0) ? 'dropdown-menu-side' : 'dropdown-menu-arrow';
        echo '<ul class="dropdown-menu">';
        foreach ($data as $submenu) {
            $href = !empty($submenu->route_name) ? 'href="' . route($submenu->route_name) . '"' : '';
            $sublink = count($submenu->submenu) ? ' dropdown-toggle' : '';
            $icon = ($submenu->icon != '') ? '<i class="' . $submenu->icon . '"></i>' : '';
            echo '<li>';
            echo '<a ' . ($href ?? '') . ' class="dropdown-item' . ($sublink ?? '') . '">' . $icon . ' ' . $submenu->name . '</a>';
            if (count($submenu->submenu) > 0) {
                generateSubmenu($submenu->submenu, $level + 1);
            }
            echo '</li>';
        }
        echo '</ul>';
    }
}

if (!function_exists('generateMenuArray')) {
    /**
     * Generate Top Menu Array
     *
     * @return void
     */
    function generateMenuArray($data, $separator = '-', $level = 0)
    {
        $array = [];
        $sep = $separator ? str_pad("", $level, $separator) : '';
        $pad = $level * 10;
        foreach ($data as $menu) {
            $menu->name = ($sep ? '<span class="text-muted" style="padding-left: ' . $pad . 'px">' . $sep . '</span> ' : '') . $menu->name;
            $array[] = $menu;
            if (count($menu->submenu) > 0) {
                $array = array_merge($array, generateMenuArray($menu->submenu, $separator, $level + 1));
            }
        }

        return $array;
    }
}
