<?php

    include 'includes/query.php';

    class share{
        public $id, $type, $serial, $weight, $manuf, $purPrice, $curValue, $netProfit;
    }
    
    class audit{
        public $date, $t_val = 0, $t_auVal = 0, $t_agVal = 0, $t_ltc = 0, $q_AU = 0, $q_AG = 0, $q_LTC = 0;
    }

    function getShare($id){
        
    }
    
    function getAllShares(){
        $shares = [];
        
        $sql = 'SELECT * FROM holdings';
        $res = query($sql);
        
        while($r = $res->fetch_assoc()){
            
            $share = new share();
            $share->id = $r['id'];
            $share->type = $r['type'];
            $share->serial = $r['serial'];
            $share->weight = $r['weightOz'];
            $share->manuf = $r['manufacturer'];
            $share->purPrice = $r['purchasePrice'];
            $share->curValue = $r['currentValue'];
            $share->netProfit = $r['netProfit'];
            
            array_push($shares, $share);
        }
        return $shares;
    }
    
    function getAudit($spot,$updateAuditLog){
        include_once 'includes/query.php';
        
        $shares = getAllShares();
        $audit = new audit();
        
        foreach($shares as $share){
            if($share->type == 'au'){
                $audit->t_auVal += ($share->weight * $spot->auAsk);
                $audit->q_AU += $share->weight;
            }
            else if($share->type == 'ag'){
                $audit->t_agVal += ($share->weight * $spot->agAsk);
                $audit->q_AG += $share->weight;
            }
            else if($share->type == 'ltc'){
                $audit->t_ltc += ($share->weight * $spot->ltc);
                $audit->q_LTC += $share->weight;
            }
        }
        
        $audit->t_val = ($audit->t_auVal + $audit->t_agVal + $audit->t_ltc);
        
        if($updateAuditLog){
            $sql = "INSERT INTO audits (auAsk,auBid,agAsk,agBid,ltc,ltcChange) VALUES ($spot->auAsk,$spot->auBid,$spot->agAsk,$spot->agBid,$spot->ltc,$spot->ltcChange);";
        
            query($sql);
        }
        
        
        return $audit;
    }
?>

