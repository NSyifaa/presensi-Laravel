<?php
#================ CATATAN PENTING: setelah membuat helper jangan lupa di dump dengan terminal -> composer dump-autoload

if (!function_exists('cek_url')) 
{
	function cek_url($link)
	{
		if($link == '')
		{
			$link = $link;
		}
		else{

			$cek_1 = strtolower(substr($link, 0, 8));

			if($cek_1 == 'https://'){
				$scr = 'https://';
			}
			else{
				$scr = 'http://';
			}

			$link = str_replace('https://', '', $link);
			$link = str_replace('http://', '', $link);

			$link = $scr.$link;
		}

		return $link;
	}
}

if (!function_exists('csToken')) 
{
    function csToken($jenis=null, $panjang=null)
    {
        #==penggunaan: jenis 0, 1, 2 dll (bisa dikombinasi, ex: 012, 204)
        $char = [
            '123456789', // jenis 0
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ', // jenis 1
            'abcdefghijklmnopqrstuvwxyz', // jenis 2
            'ABCDEFG', // jenis 3
            'abcdefg' // jenis 4
        ];

        $token      = '';
        $karakter   = '';

        if($jenis == 'uuid'){
            // ex: ed676283-009b-4fe6-9c12-7dd1ff8785a4
            $token .= csToken('04', 4).date('ym').'-';
            $token .= csToken('04', 2).date('d').'-';
            $token .= csToken('04', 4).'-';
            $token .= csToken('04', 4).'-';
            $token .= date('His').csToken('04', 6);
        }
        else if($jenis == 'time'){
            $token .= csToken('0', 1).date('ymd').csToken('0', 1).date('His').csToken('0', 1).rand(10000, 99999);
        }
        else if($jenis != null){
            foreach(str_split($jenis) as $i){
                $karakter .= $char[$i];
            }

            $panjang = $panjang ? $panjang : 20;
            for ($i=0; $i < $panjang ; $i++) { 
                $pos = rand(0, strlen($karakter)-1);
                $token .=$karakter[$pos];
            }
        }
        else {
            $karakter .= csToken('1', 1).date('ym').rand(1, 9);
            $karakter .= csToken('1', 1).date('dH').rand(1, 9);
            $karakter .= csToken('1', 1).date('is').rand(1, 9);
            $karakter .= rand(10000, 99999);

            $token = $karakter;
        }

        return $token;
    }
}

if (!function_exists('encodeValue')) 
{
	function encodeValue($val)
	{
		$arr1       = str_split($val, 1);
		$spasi      = '3nc0d3';
		$pelangkap  = 'd3c0m';
		$rand       = rand(2, 3);

		$en1 = '';
		foreach($arr1 as $ar1) {
			$en1 .= $ar1.csToken('012', 1);
		}

		$en1 		= csToken('012',$rand).str_replace(' ', base64_encode($spasi), $en1).$rand;
		$en1 		= str_replace('=', '', base64_encode($en1));
		$panjang 	= strlen($en1);

		if($panjang % 2 == 0)
		{
			#== genap
			$bagi_2 = $panjang / 2;	
		}
		else{

			#== ganjil
			$en1 		= $en1.$pelangkap;
			$panjang 	= strlen($en1);
			$bagi_2   	= $panjang / 2;
		}

		$bagian_awal 	= substr($en1, 0, -$bagi_2);
		$bagian_tengah 	= csToken('012',$rand+2);
		$bagian_akhir	= substr($en1, $bagi_2);
		$jkn            = csToken('012',2).(sprintf('%05d',$bagi_2));

		$en1 = $bagian_awal.$bagian_tengah.$bagian_akhir.$jkn;
		$en1 = base64_encode($en1);
		$en1 = str_replace('=', '', $en1);
		$en1 = str_replace('+', '404403', $en1);

		return $en1;
	}
}

if (!function_exists('decodeValue')) 
{
	function decodeValue($val)
	{
		$spasi      = '3nc0d3';
		$pelangkap  = 'd3c0m';
		
		$en1 = str_replace('404403', '+', $val);
		$en1 = base64_decode($en1);

		$bagi_2 = substr($en1, -7);
		$bagi_2 = (int)substr($bagi_2, -5);

		$en1 = substr($en1, 0, -7);

		$bagian_awal 	= substr($en1, 0, $bagi_2);
		$bagian_akhir	= substr($en1, -$bagi_2);

		$en1 	= str_replace($pelangkap, '', $bagian_awal.$bagian_akhir);
		$en1 	= base64_decode($en1);
		$jml 	= substr($en1, -1);

		if(filter_var($jml, FILTER_VALIDATE_INT) !== false){
			$en1 	= substr($en1, $jml, -1);
			$en1 	= str_replace(base64_encode($spasi), ' ', $en1);
			$arr1 	= str_split($en1, 2);
	
			$dec1 = '';
			foreach($arr1 as $ar1) {
				$dec1 .= substr($ar1, 0, 1);
			}
	
			return $dec1;
		}
		else{

			return '0';
		}
	}
}

if (!function_exists('petik')) 
{
	function petik($val)
	{
		return "'".$val."'";
	}
}

if (!function_exists('limitWords')) 
{
	function limitWords($string, $word_limit)
	{
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
}

if (!function_exists('numFormat')) 
{
	function numFormat($angka, $prefix=null)
	{
		$x = number_format($angka,0,",", ($prefix == null ? '.' : $prefix));
		return $x;
	}
}

if (!function_exists('getFormatWhatsapp')) 
{
    function getFormatWhatsapp($nohp)
    {
		$hp = $nohp;
		$nohp = str_replace(" ","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace("(","",$nohp);
		// kadang ada penulisan no hp (0274) 778787
		$nohp = str_replace(")","",$nohp);
		// kadang ada penulisan no hp 0811.239.345
		$nohp = str_replace(".","",$nohp);
	
		// cek apakah no hp mengandung karakter + dan 0-9
		if(!preg_match('/[^+0-9]/',trim($nohp))){
			// cek apakah no hp karakter 1-3 adalah +62
			if(substr(trim($nohp), 0, 3)=='62'){
				$hp = trim($nohp);
			}
			// cek apakah no hp karakter 1 adalah 0
			elseif(substr(trim($nohp), 0, 1)=='0'){
				$hp = '62'.substr(trim($nohp), 1);
			}
		}
		return $hp;
    }
}

if (!function_exists('replaceScript')) 
{
	function replaceScript($kata)
	{
		$key = array(
			"'"				=> '',
			'src='			=> '',
			'SRC='			=> '',
			'script'		=> '',
			'SCRIPT'		=> '',
			'http://'		=> '',
			'HTTP://'		=> '',
			'https://'		=> '',
			'HTTPS://'		=> '',
			'java'			=> '',
			'JAVA'			=> '',
			'TYPE'			=> '',
			'type='			=> '',
			'*'				=> '',
			'select'		=> '',
			'SELECT'		=> '',
			'//'			=> '' 
		);

		$i3 = trim(addslashes(stripslashes(str_replace(array_keys($key), $key, $kata))));

		return $i3;
	}
}

if (!function_exists('bulanIdn')) 
{
	function bulanIdn($bulan_gt)
	{
		$key_bln = array(
			"Jan"=>'Januari',
			"Feb"=>'Februari',
			"Mar"=>'Maret',
			"Apr"=>'April',
			"May"=>'Mei',
			"Jun"=>'Juni',
			"Jul"=>'Juli',
			"Aug"=>'Agustus',
			"Sep"=>'September',
			"Oct"=>'Oktober',
			"Nov"=>'November',
			"Dec"=>'Desember' 
		);

		$i = stripslashes(str_replace(array_keys($key_bln), $key_bln, $bulan_gt));

		return $i;
	}
}

if (!function_exists('bulanEn')) 
{
	function bulanEn($bulan_gt)
	{
		$key_bln = array(
			"Jan"=>'January',
			"Feb"=>'February',
			"Mar"=>'March',
			"Apr"=>'April',
			"May"=>'May',
			"Jun"=>'June',
			"Jul"=>'July',
			"Aug"=>'August',
			"Sep"=>'September',
			"Oct"=>'October',
			"Nov"=>'November',
			"Dec"=>'December' 
		);

		$i = stripslashes(str_replace(array_keys($key_bln), $key_bln, $bulan_gt));

		return $i;
	}
}

if (!function_exists('hariNum')) 
{
	function hariNum($hari_gt)
	{
		$key_hrn = array(
			"1"=>'Senin',
			"2"=>'Selasa',
			"3"=>'Rabu',
			"4"=>'Kamis',
			"5"=>'Jumat',
			"6"=>'Sabtu',
			"7"=>'Minggu' 
		);

		$i = stripslashes(str_replace(array_keys($key_hrn), $key_hrn, $hari_gt));

		return $i;
	}
}

if (!function_exists('hariIdn')) 
{
	function hariIdn($hari_gt)
	{
		$key_hrn = array(
			"Mon"=>'Senin',
			"Tue"=>'Selasa',
			"Wed"=>'Rabu',
			"Thu"=>'Kamis',
			"Fri"=>'Jumat',
			"Sat"=>'Sabtu',
			"Sun"=>'Minggu' 
		);

		$i = stripslashes(str_replace(array_keys($key_hrn), $key_hrn, $hari_gt));

		return $i;
	}
}

if (!function_exists('hariEn')) 
{
	function hariEn($hari_gt)
	{
		$key_hrn = array(
			"Senin"	=>'Mon',
			"Selasa"=>'Tue',
			"Rabu"	=>'Wed',
			"Kamis"	=>'Thu',
			"Jumat"	=>'Fri',
			"Sabtu"	=>'Sat',
			"Minggu"=>'Sun' 
		);

		$i = stripslashes(str_replace(array_keys($key_hrn), $key_hrn, $hari_gt));

		return $i;
	}
}

if (!function_exists('tanggalIdn')) 
{
	function tanggalIdn($tanggal)
	{
		$get_tanggal = substr($tanggal, 8, 2);
		$get_bulan = substr($tanggal, 5, 2);
		$get_tahun = substr($tanggal, 0, 4);
		
		$key_bln = array(
			"01"=>'Januari',
			"02"=>'Februari',
			"03"=>'Maret',
			"04"=>'April',
			"05"=>'Mei',
			"06"=>'Juni',
			"07"=>'Juli',
			"08"=>'Agustus',
			"09"=>'September',
			"10"=>'Oktober',
			"11"=>'November',
			"12"=>'Desember' 
		);

		$rpl_bulan = str_replace(array_keys($key_bln), $key_bln, $get_bulan);

		return $get_tanggal.' '.$rpl_bulan.' '.$get_tahun;
	}
}

if (!function_exists('tanggalEn')) 
{
	function tanggalEn($tanggal)
	{
		$get_tanggal = substr($tanggal, 8, 2);
		$get_bulan = substr($tanggal, 5, 2);
		$get_tahun = substr($tanggal, 0, 4);
		
		$key_bln = array(
			"01"=>'January',
			"02"=>'February',
			"03"=>'March',
			"04"=>'April',
			"05"=>'May',
			"06"=>'June',
			"07"=>'July',
			"08"=>'August',
			"09"=>'September',
			"10"=>'October',
			"11"=>'November',
			"12"=>'December' 
		);

		$rpl_bulan = str_replace(array_keys($key_bln), $key_bln, $get_bulan);

		return $get_tanggal.' '.$rpl_bulan.' '.$get_tahun;
	}
}
?>