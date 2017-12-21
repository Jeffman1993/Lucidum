<?php

class Holding{
    public $id, $type, $serial, $weight, $manufacturer, $purchasePrice, $purchasePriceOz, $currentVal, $prevValue, $netProfit, $interestRate, $returnClass;
}

class Holdings{
    public $gold = [], $silver = [], $ltc = [];
}

function getHoldings($spot){
    include_once 'includes/query.php';
    
    $sql = 'SELECT * FROM holdings';
    $holdings = new Holdings();
    
    $res = query($sql);
    
    while($r = $res->fetch_assoc()){
        $id = $r['id'];
        $type = $r['type'];
        $serial = $r['serial'];
        $weight = $r['weightOz'];
        $manufacturer = $r['manufacturer'];
        $purchasePrice = $r['purchasePrice'];
        $currentVal = $r['currentValue'];
        $netProfit = $r['netProfit'];
        
        $holding = new Holding();
        $holding->id = $id;
        $holding->type = $type;
        $holding->serial = $serial;
        $holding->weight = $weight;
        $holding->manufacturer = $manufacturer;
        $holding->purchasePrice = $purchasePrice;
        $holding->purchasePriceOz = $holding->purchasePrice / $holding->weight;     //Error with grams vs oz, too tired can't be fucked to fix it now.
        $holding->currentVal = $currentVal;
        $holding->return = $netProfit;
        $holding->interestRate;
        
        switch ($holding->type){
            case 'au':
                $holding->currentVal = $holding->weight * $spot->auAsk;
                $holding->return = $holding->currentVal - $holding->purchasePrice;
                $holding->interestRate = (($holding->currentVal - $holding->purchasePrice) / $holding->purchasePrice) * 100;
                
                if($holding->interestRate < 0){
                    $holding->returnClass = 'tdRed';
                }
                else if($holding->interestRate > 0) {
                    $holding->returnClass = 'tdGreen';
                }
                
                array_push($holdings->gold, $holding);
                break;
            case 'ag':
                $holding->currentVal = $holding->weight * $spot->agAsk;
                $holding->return = $holding->currentVal - $holding->purchasePrice;
                $holding->interestRate = (($holding->currentVal - $holding->purchasePrice) / $holding->purchasePrice) * 100;
                
                if($holding->interestRate < 0){
                    $holding->returnClass = 'tdRed';
                }
                else if($holding->interestRate > 0) {
                    $holding->returnClass = 'tdGreen';
                }
                
                array_push($holdings->silver, $holding);
                break;
            case 'ltc':
                $holding->currentVal = $holding->weight * $spot->ltc;
                $holding->return = $holding->currentVal - $holding->purchasePrice;
                $holding->interestRate = (($holding->currentVal - $holding->purchasePrice) / $holding->purchasePrice) * 100;
                
                if($holding->interestRate < 0){
                    $holding->returnClass = 'tdRed';
                }
                else if($holding->interestRate > 0) {
                    $holding->returnClass = 'tdGreen';
                }
                
                array_push($holdings->ltc, $holding);
                break;
        }
    }
    return $holdings;
}

?>

