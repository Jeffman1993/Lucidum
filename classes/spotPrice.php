<?php

    class SpotPrice{
        public $date, $auAsk, $auBid, $agAsk, $agBid, $ltc, $ltcChange;
    }

    function getSpot(){
        include 'includes/simple_html_dom.php';
        
        $html = file_get_html('http://www.kitco.com/market/');
        $silverBid = $html->find('td[id=AG-bid]', 0)->innertext;
        $silverAsk = $html->find('td[id=AG-ask]', 0)->innertext;
        $goldBid = $html->find('td[id=AU-bid]', 0)->innertext;
        $goldAsk = $html->find('td[id=AU-ask]', 0)->innertext;
        
        $html = file_get_html('https://ethereumprice.org/ltc/');
        $ltc = $html->find('span[id=ep-price]', 0)->innertext;
        $ltcChange = $html->find('span[id=ep-change]', 0)->innertext;
        
        $spotPrice = new SpotPrice();
        $spotPrice->agAsk = $silverAsk;
        $spotPrice->agBid = $silverBid;
        $spotPrice->auAsk = $goldAsk;
        $spotPrice->auBid = $goldBid;
        $spotPrice->ltc = $ltc;
        $spotPrice->ltcChange = $ltcChange;
        $spotPrice->date = date('m/d/Y h:i:s a', time());
        
        return $spotPrice;
    }
    
    function getSavedSpot($id = NULL){
        include_once 'includes/query.php';
        
        $sql = 'SELECT * FROM `audits` ORDER BY date DESC LIMIT 1;';
        
        $res = query($sql);
        
        $r = $res->fetch_assoc();
        
        $spotPrice = new SpotPrice();
        $spotPrice->agAsk = $r['agAsk'];
        $spotPrice->agBid = $r['agBid'];
        $spotPrice->auAsk = $r['auAsk'];
        $spotPrice->auBid = $r['auBid'];
        $spotPrice->ltc = $r['ltc'];
        $spotPrice->ltcChange = $r['ltcChange'];
        $spotPrice->date = $r['date'];
        
        return $spotPrice;
    }
?>

