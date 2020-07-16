<?php
namespace app\models;

class Crypt {

    static public function enc($s)
    {
        //$s = base64_encode($s);
        $sl = mb_strlen($s);

        $cs = '';

        $k = '2853028458381264';
        $kl = mb_strlen($k);

        $i = 0;

        $crypt = '';

        while($i <= $sl)
        {
            $c = $s{$i};
            $s_code = hexdec(bin2hex($c));

            if($i%6 == 0)
            {
                $n_code = ($s_code+(int)$k{$i%$kl}-(int)$k{($i%$kl)+1});
            } elseif($i%4 == 0) {
                $n_code = ($s_code+(int)$k{$i%$kl}+(int)$k{($i%$kl)-1}+(int)$k{($i%$kl)-2});
            }  elseif($i%12 == 0) {
                $n_code = ($s_code+(int)$k{$i%$kl}+(int)$k{($i%$kl)-5}+(int)$k{($i%$kl)-10}+(int)$k{($i%$kl)-2});
            } else {
                $n_code = ($s_code+(int)$k{$i%$kl});
            }


            $nc = dechex($n_code);


            if($i%2)
            {
                $crypt=$nc.$crypt;
            } else {
                $crypt=$crypt.$nc;
            }

            $i++;
            $cs.=(string)(ord($c)).'-';
        }

        return $cs.' '.$crypt;
    }

    static public function dec($ssq)
    {
        $temp = $ssq{mb_strlen($ssq)};
        $ssq{mb_strlen($ssq)} = 0;
        $ssq.=$temp;

        $hs = str_split($ssq, 2);
        $ch = count($hs);

        $k = '2853028458381264';
        $kl = mb_strlen($k);

        $pos = (int)($ch/2);
        $i = 0;

        $s = '';
        $sf = '';
        $ss = '';
        $ssf = '';

        $arr = [];
        $p_arr = '';
        $pc_arr = '';

        while($i <= $ch)
        {
            if($i%2)
            {
                $pos+=$i;
            } else {
                $pos-=$i;
            }

            $p_arr.= $pos. ' - ';
            $pc_arr.= '['.$pos.']';
            $arr[]=$hs[$pos];
            $i++;
        }

        foreach ($arr AS $i => $e)
        {
            $elem = hexdec($e);

            if($i%6 == 0)
            {
                $c = ($elem-(int)$k{$i%$kl}-(int)$k{($i%$kl)+1});
            } elseif($i%4 == 0) {
                $c = ($elem-(int)$k{$i%$kl}+(int)$k{($i%$kl)-1}+(int)$k{($i%$kl)-2});
            } elseif($i%12 == 0) {
                $c = ($elem-(int)$k{$i%$kl}+(int)$k{($i%$kl)-5}+(int)$k{($i%$kl)-10}+(int)$k{($i%$kl)-2});
            } else {
                $c = ($elem-(int)$k{$i%$kl});
            }

            $s.=chr((int)$c);
            $sf.='['.$e.']';
            $ssf.='|'.$elem.'|'.'='.chr($elem).'  ';
            //$s = base64_decode($s);
            //$ss = base64_decode($ss);
        }

        return ((int)($ch/2)+1).' '.mb_strlen($ssq).' '.$ch.'<br>_________<br> '.$s.'<br>_________<br> '.$sf.'<br>_________<br> '.$ssf.'<br>_________<br> '.$p_arr;
    }
}