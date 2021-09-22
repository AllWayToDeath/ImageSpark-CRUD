<?php

$stocksPrice = array(9,11,8,5,7,10);


function foundMaxProfit(array $priceChart)
{
    if(!isset($priceChart))
        return null;
    if(0 == count($priceChart))
        return null;

    $profit = array(
        "buy" => "day"
        ,"sell" => "day"
        ,"profit" => "cost"
    );

    for($i = 0; $i < count($priceChart); $i++)
    {
        $price = $priceChart[$i];

        //all that more then $price
        for($j = $i; $i < count($priceChart); $j++)
        {
            $currentPrice = $priceChart[$j];
            if($price < $currentPrice)
            {
                $price = $currentPrice;
                $profit["sell"] = $j;
            }
        }
        
    }
    /*
        самый максимальный от текущего
        вычисляем их профит
        
    */
}





$maxPrice = max($stocksPrice);
$dayMaxPrice = array_keys($stocksPrice, $maxPrice);

$minPrice = min($stocksPrice);
$dayMinPrice = array_keys($stocksPrice, $minPrice);

$profit = $maxPrice - $minPrice;

echo "\n";
echo "Buy stocks at ".($dayMinPrice[0]+1)."-th day as $minPrice\n";
echo "Sell stocks at ".($dayMaxPrice[0]+1)."-th day as $maxPrice\n";
echo "Profit is one stock: $profit\n";
echo "\n";