
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    include 'classes/share.php'; include 'classes/spotPrice.php'; include 'classes/holdings.php';

    if(isset($_POST['u'])){
        $updateSpot = $_POST['u'];
    }
    else {
        $updateSpot = false; 
    }
    
    if($updateSpot){
        $spot = getSpot();
    }
    else {
        $spot = getSavedSpot();
   }
    
   $holdings = getHoldings($spot);
   
   $audit = getAudit($spot,$updateSpot);
    
    if($updateSpot)
        header('Location: index.php');
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Lucidum</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <div style="height: 4em; margin-bottom: 3em;">
            <div id="header">Lucidum</div>
            <div style="float: right; width: auto; padding: 1.6em; padding-right: 3em;">Last Updated: <?php echo $spot->date; ?> 
            <form action="index.php" method="POST"><input type="hidden" name="u" value="true" /><input type="submit" value="Update" /></form></div>
        </div>
        
        <div id="holdings">
            <div style="color:#dddddd; font-size: 2em; text-align: center; margin-bottom: .0em;">Value of Current Holdings</div>
            <div style="color:#dddddd; font-size: 1.5em; text-align: center; margin-bottom: .8em;"><?php echo '$' . round($audit->t_val, 2); ?></div>
            
            <span class='h_item'>Gold <?php echo '$' . round($audit->t_auVal, 2); ?></span>
            <span class='h_item'>Silver <?php echo '$' . round($audit->t_agVal, 2); ?></span>
            <span class='h_item'>LTC <?php echo '$' . round($audit->t_ltc, 2); ?></span>
        </div>
        
        <div id="dashboard">
            
            <table class="spot_panel">
                <?php
                    echo
                    "<tr>
                        <th></th>
                        <th>Ask</th>
                        <th>Bid</th>
                    </tr>
                    <tr>
                        <th>Gold</th>
                        <td>$spot->auAsk</td>
                        <td>$spot->auBid</td>
                    </tr>
                    <tr>
                        <th>Silver</th>
                        <td>$spot->agAsk</td>
                        <td>$spot->agBid</td>
                    </tr>
                    <tr>
                        <th>LTC</th>
                        <td>$spot->ltc</td>
                        <td>$spot->ltc</td>
                    </tr>";
                ?>
            </table>
            
        </div>
        
        <div id="info_panel">
            <div style="height: 15%; text-align: center;">
                <div class="holding_toolbar">
                    <h3 style="text-decoration: underline;">Holdings by Volume</h3>
                    <table style="color: white; text-align: center; font-size: 1.3em; margin: auto; border-collapse: separate; border-spacing: .5em;">
                        <tr>
                            <th>Gold</th>
                            <td><?php echo $audit->q_AU ?></td>
                            <td>oz</td>
                        </tr>
                        <tr>
                            <th>Silver</th>
                            <td><?php echo $audit->q_AG ?></td>
                            <td>oz</td>
                        </tr>
                        <tr>
                            <th>LTC</th>
                            <td><?php echo $audit->q_LTC ?></td>
                            <td>coin</td>
                        </tr>
                    </table>
                </div>
                <div class="holding_toolbar">
                    <h3 style="text-decoration: underline;">Gold 24hr Change</h3>
                    <h1>N/A<?php ?></h1>
                </div>
                <div class="holding_toolbar">
                    <h3 style="text-decoration: underline;">Silver 24hr</h3>
                    <h1>N/A<?php ?></h1>
                </div>
                <div class="holding_toolbar">
                    <h3>LTC 24hr Change</h3>
                    <h1><?php echo $spot->ltcChange; ?></h1>
                </div>
            </div>
            
            <div class="holdings">
                <h2 style="color: gold; text-decoration: underline;">Gold</h2>
                <table>
                    <tr>
                        <th>Manufacturer</th>
                        <th>Serial #</th>
                        <th>Quantity/Oz</th>
                        <th>Purchase Oz</th>
                        <th>Purchase Price</th>
                        <th>Current Value</th>
                        <th>Return</th>
                        <th>% Return</th>
                    </tr>
                    
                    <?php
                    foreach($holdings->gold as $h){
                        echo "
                        <tr>
                            <td>$h->manufacturer</td>
                            <td>$h->serial</td>
                            <td>$h->weight</td>
                            <td>$h->purchasePriceOz</td>
                            <td>$h->purchasePrice</td>
                            <td>$h->currentVal</td>
                            <td class='$h->returnClass'>$h->return</td>
                            <td>$h->interestRate</td>
                        </tr>
                        ";
                    }
                    ?>
                </table>
                
                <br><br>
                
                <h2 style="color: silver; text-decoration: underline;">Silver</h2>
                <table>
                    <tr>
                        <th>Manufacturer</th>
                        <th>Serial #</th>
                        <th>Quantity/Oz</th>
                        <th>Purchase Oz</th>
                        <th>Purchase Price</th>
                        <th>Purchase Price</th>
                        <th>Current Value</th>
                        <th>Return</th>
                        <th>% Return</th>
                    </tr>
                    
                    <?php
                    foreach($holdings->silver as $h){
                        echo "
                        <tr>
                            <td>$h->manufacturer</td>
                            <td>$h->serial</td>
                            <td>$h->weight</td>
                            <td>$h->purchasePriceOz</td>
                            <td>$h->purchasePrice</td>
                            <td>$h->currentVal</td>
                            <td class='$h->returnClass'>$h->return</td>
                            <td>$h->interestRate</td>
                        </tr>
                        ";
                    }
                    ?>
                </table>
                
                <br><br>
                
                <h2 style="color: blue; text-decoration: underline;">LTC</h2>
                <table>
                    <tr>
                        <th>Manufacturer</th>
                        <th>Serial #</th>
                        <th>Quantity/Coin</th>
                        <th>Purchase Coin</th>
                        <th>Purchase Price</th>
                        <th>Current Value</th>
                        <th>Return</th>
                        <th>% Return</th>
                    </tr>
                    
                    <?php
                    foreach($holdings->ltc as $h){
                        echo "
                        <tr>
                            <td>$h->manufacturer</td>
                            <td>$h->serial</td>
                            <td>$h->weight</td>
                            <td>$h->purchasePriceOz</td>
                            <td>$h->purchasePrice</td>
                            <td>$h->currentVal</td>
                            <td class='$h->returnClass'>$h->return</td>
                            <td>$h->interestRate</td>
                        </tr>
                        ";
                    }
                    ?>
                </table>
                <iframe src="https://live.blockcypher.com/widget/ltc/LYHKBX4GZkG2JaDU11LJ24USP7sLMrxHSe/balance/" style="overflow:hidden;" frameborder="0"></iframe>
            </div>
        </div>
        
    </body>
</html>
