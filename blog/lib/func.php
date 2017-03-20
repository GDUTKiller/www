<?php
/**
*author Ñî¼ºÀÖ 2017/1/13
*
*/

/**
* 成功的提示信息
*/

function succ($res) {
    $result = 'succ';
    require(ROOT . '/view/admin/info.html');
    exit();
}

/**
* 失败返回的报错信息
*/

function error($res) {
    $result = 'fail';
    require(ROOT . '/view/admin/info.html');
    exit();
}



/**
 * 获取ip
 * @return str $realip ip地址
 */

function getIp() {
    static $realip = null;
    if($realip !== null) {
        return $realip;
    }

    if(getenv('HTTP_X_FORWARDED_FOR')) {
        $realip = getenv('HTTP_X_FORWARDED_FOR');
    } else if(getenv('HTTP_CLIENT_IP')){
        $realip = getenv('HTTP_CLIENT_IP');
    } else {
        $realip = getenv('REMOTE_ADDR');
    }

    return $realip;
}

/**
 * [cPager description]
 * 假设要显示5个页码
 * @param  int $num 总文章数
 * @param  int $cnt 每页显示文章数
 * @param  int $curr 当前页码数
 * @return array  $pagers 返回一个页码数=>地址栏值的关联数组
 */
function cPager($num, $cnt, $curr) {
    //计算最大页码数
    $max = ceil($num / $cnt);
    //计算最左边的页码
    $left = max($curr - 2, 1);
    //计算最右边的页码
    $right = $left + 4;
    $right = min($max, $right);

    //当页码靠右边，不足5个页码时，6 7 [8] 9
    //再次确认左侧页码数
    $left = $right - 4;
    $left = max($left, 1);

    $pagers = array();
    //将获取的5个页码数 放进数组
    for($i = $left; $i <= $right; $i++) {
        $arr['page'] = $i;
        $pagers[$i] = http_build_query($arr);
    }

    return $pagers;
}

/**
 * 生成一个目录
 * @return mixed str($path) / bool(false)
 */
function createDir() {
    //相对路径 /upload/2017/01/17
    $path = '/upload/' . date('Y/m/d');
    //绝对路径
    $abs = ROOT . $path;
    if(is_dir($abs) || mkdir($abs, 0777, true)) {
        return $path;
    } else {
        return false;
    }
}

/**
 * 获取文件后缀
 * @param  str $name 文件名
 * @return str 文件后缀
 */
function getExt($name) {
    return strrchr($name, '.');
}

/**
 * 获取随机字符串
 * @param int 默认6
 * @return  str 随机字符串
 */
function randStr($length = 6) {
    $str = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789');
    return substr($str, 0, $length);
}

/**
 * 等比例生成缩略图，比例不合适两端留白
 * @param  str  $ori 原始图片相对路径 '/upload/2017/01/17/afdsdf.jpg'
 * @param  integer $dw  缩略图的宽
 * @param  integer $dh  缩略图的高
 * @return mixed str $path/ bool false 缩略图的相对路径
 */
function makeThumb($ori, $dw=200, $dh=200) {
    $path = dirname($ori) . '/' . randStr() . '.png';

    $opic = ROOT . $ori;//大图的绝对路径
    $opath = ROOT . $path;//小图的绝对路径

    //原图的宽  高  类型
    if(!list($sw, $sh, $type) = getimagesize($opic)) {
        return false;
    }

    /**1 = GIF，2 = JPG，3 = PNG，4 = SWF，5 = PSD，6 = BMP，7 = TIFF(intel byte order)，8 = TIFF(motorola byte order)，9 = JPC，10 = JP2，11 = JPX，12 = JB2，13 = SWC，14 = IFF，15 = WBMP，16 = XBM**/
    $map = array(
        1 => 'imagecreatefromgif',
        2 => 'imagecreatefromjpeg',
        3 => 'imagecreatefrompng',
        6 => 'imagecreatefromwbmp',
        15=> 'imagecreatefromwbmp'
    );

    //如果传来的图片类型不再$map里
    if(!isset($map[$type])) {
        return false;
    }

    $func = $map[$type];
    //创建大画布
    $big = $func($opic);
    //创建小画布
    $small = imagecreatetruecolor($dw, $dh);
    $white = imagecolorallocate($small, 255, 255, 255);
    imagefill($small, 0, 0, $white);

    //计算缩略比
    $rate = min($dw/$sw, $dh/$sw);

    //真正的宽高
    $rw = $rate * $sw;
    $rh = $rate * $sh;
    imagecopyresampled($small, $big, 0, 0, 0, 0, $rw, $rh, $sw, $sh);

    //保存缩略图
    imagepng($small, $opath);

    imagedestroy($big);
    imagedestroy($small);

    return $path;
}

/**
 * 判断是否设置$_COOKIE['name'];
 * @return bool
 */
function acc() {
    return isset($_COOKIE['name']);
}

/**
 * 转移字符串 对get post cookie数组进行转义
 * @param  arr $arr 要转义的数组
 * @return arr $arr 转义后的数组
 */
function _addslashes($arr) {
    foreach ($arr as $k => $v) {
        if(is_string($v)) {
            $arr[$k] = addslashes($v);
        } else if(is_array($v)) {
            $arr[$k] = _addslashes($v);
        }
    }

    return $arr;
}
?>