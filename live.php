<?php

ini_set('wincache.ocenabled', false);

use Posnet\Printer\Adapter\Posnet\RequestFrame;
use Posnet\Printer\Transport\SerialPort;

require_once __DIR__ . '/vendor/autoload.php';

$comPort = 'COM3';

$modeCommand = 'mode '.$comPort.' baud=115200 parity=n data=8 stop=1 rts=on to=off';
exec($modeCommand);

$frame = new RequestFrame('!sdev');
$handle = fopen('\\\\.\\' . $comPort, 'r+b');
$written = fwrite($handle, $frame->build());
sleep(1);

$buffer = '';
while(($char = fread($handle, 1)) !== false){

    echo '.';

    $buffer .= $char;
    if($char == "\x03"){
        break;
    }
}


fclose($handle);
var_dump($buffer);
