<?php
defined('_JEXEC') or die('Acesso restrito!'); 
/*
 *
 * @author Rafael Clares
 */

/* 

Aplica máscara

$cnpj = "11222333000199";
$cpf = "00100200300";
$cep = "08665110";
$data = "10102010";
 
echo mask($cnpj,'##.###.###/####-##');
echo mask($cpf,'###.###.###-##');
echo mask($cep,'#####-###');
echo mask($data,'##/##/####');
 */
function utils_maskToCPF($val)
{
    return utils_mask($val,'###.###.###-##');
}
function utils_maskToCNPJ($val)
{
    return utils_mask($val,'##.###.###/####-##');
}
function utils_maskToCPFCNPJ($val)
{
    $mask = '###.###.###-##';
    
    if(strlen($val) > 11)
    {
        $mask = '##.###.###/####-##';
    }
    
    return utils_mask($val,$mask);
}

function utils_maskToPhone($val)
{
    $phone = utils_getNumbers($val); 
    
    $mask = '';
    
    if(strlen($phone) == 10)
    {
        $mask = '(##) ####-####';
    }
    else if(strlen($phone) == 11)
    {
        $mask = '(##) #####-####';
    }
    else
    {
        return $val; 
    }
    
    return utils_mask($phone,$mask);
}

function utils_mask($val, $mask)
{
    $maskared = '';
    $k = 0;

    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
        if($mask[$i] == '#')
        {
            if(isset($val[$k]))
            $maskared .= $val[$k++];
        }
        else
        {
            if(isset($mask[$i]))
            $maskared .= $mask[$i];
        }
    }

    return $maskared;
}
function utils_getNumbers($string)
{
    return preg_replace("/[^0-9]/","", $string);
}
function utils_selected($value, $prev)
{			
    return $value==$prev ? 'selected="selected"' : ''; 
}
/*
 * method to encrypt or decrypt a plain text string 
 * initialization vector has to be the same when encrypting and decrypting 
 * you can also choose to append the IV to the encrypted text and get it when decrypting 
 *
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return bool|string
 */
function utils_encrypt($string) {
    $output = false;

    $crypt_key = 'a3g8k4@#$%ELZ*65';
    // initialization vector 
    $iv = md5(md5($key));

    $output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($crypt_key), $string, MCRYPT_MODE_CBC, $iv);
    $output = base64_encode($output);

    return $output;
}
function utils_decrypt($string) {
    $output = false;

    $crypt_key = 'a3g8k4@#$%ELZ*65';

    // initialization vector 
    $iv = md5(md5($key));

    $output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($crypt_key), base64_decode($string), MCRYPT_MODE_CBC, $iv);
    $output = rtrim($output, "");
       
    return $output;
}
/**
 * Redirect with POST data.
 *
 * @param string $url URL.
 * @param array $post_data POST data. Example: array('foo' => 'var', 'id' => 123)
 * @param array $headers Optional. Extra headers to send.
 */
function utils_redirect_post($url, array $data, array $headers = null) 
{
    $params = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    
    if (!is_null($headers)) 
   {
        $params['http']['header'] = '';
        foreach ($headers as $k => $v) {
            $params['http']['header'] .= "$k: $v\n";
        }
    }
    
    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    
    if ($fp) 
    {
        echo @stream_get_contents($fp);
        die();
    } else {
        // Error
        throw new Exception("Error loading '$url', $php_errormsg");
    }
}

function utils_getDays($dateIni, $dateEnd)
{
    $date_ini = strtotime($dateIni); 
    $date_end = strtotime($dateEnd);
     
    $datediff = $date_end - $date_ini;

    return abs(floor($datediff/(60*60*24)));
}

function utils_unique_id($lengh = 9) 
{
    return substr(md5(uniqid(mt_rand(), true)), 0, $lengh);
}

function utils_addDays($date, $daysAdd) 
{
    return date('Y-m-d', strtotime($date. ' + '.$daysAdd.' days'));
}

function utils_addMonths($date, $monthsAdd) 
{
    return date('Y-m-d', strtotime($date. ' + '.$monthsAdd.' months'));
}
function utils_fileReadAll($path) 
{
    $text = '';

    if(file_exists($path))
    {
        // abre o arquivo
        $ponteiro = fopen($path, "r");

        // ler o arquivo
        while(!feof($ponteiro))
        {
            // lê uma linha do arquivo
            $text .= fgetc($ponteiro); 
        }
        // fecha o ponteiro do arquivo
        fclose ($ponteiro);
    }

    return $text;
}

function utils_DateNow($withTime = false)
{
	$format = $withTime ? 'Y-m-d H:i:s' : 'Y-m-d';

	return date($format);
	
}
function utils_getDate($data, $withTime = false, $timezone = false)
{
	$format = $withTime ? 'd/m/Y H:i:sP' : 'd/m/Y';
	
	//$dateResult = date_create($data, timezone_open('America/Sao_Paulo'));

	//return date_format($dateResult, $format);
	
	$format = $withTime ? 'd/m/Y H:i:s' : 'd/m/Y';

	return date($format, strtotime($data . ($timezone == true ? ' -3 hours': '')));
	
}

function utils_getDateMySQL($data)
{
	return date(implode("-", array_reverse(explode("/", $data))));
}

?>
