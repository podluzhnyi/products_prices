<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;
use DatePeriod;
use DateInterval;

class Price extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'prices';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'price', 'start_date', 'end_date'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public static function GetChartData($prices, $start_date, $end_date){

        $from = new DateTime($start_date);
        $to   = new DateTime($end_date);

        $period = new DatePeriod($from, new DateInterval('P1D'), $to);

        $arrayOfDates = array_map(
            function($item){return $item->format('Y-m-d');},
            iterator_to_array($period)
        );

        //Create prices array
        $arrayPrices = array();
        $cd = count($arrayOfDates);
        for($d=0; $d<$cd; $d++){

            if(empty($arrayPrices[$arrayOfDates[$d]]['pd'])) $arrayPrices[$arrayOfDates[$d]]= ['price'=>session('product_price'), 'pd'=>10000, 'price_2'=>session('product_price'), 'pi'=>'2000-01-01'];

            foreach($prices as $price){

                $days_period = (strtotime($price['end_date'])-strtotime($price['start_date']))/(60*60*24);

                if(strtotime($arrayOfDates[$d]) >= strtotime($price['start_date']) && strtotime($arrayOfDates[$d]) <= strtotime($price['end_date'])){
                    //With a shorter period
                    if( $days_period < $arrayPrices[$arrayOfDates[$d]]['pd']) {
                        $arrayPrices[$arrayOfDates[$d]]['price'] = $price['price'];
                        $arrayPrices[$arrayOfDates[$d]]['pd'] = $days_period;
                    }

                    //Installed later
                    if( strtotime($price['updated_at']) > strtotime($arrayPrices[$arrayOfDates[$d]]['pi'])) {
                        $arrayPrices[$arrayOfDates[$d]]['price_2'] = $price['price'];
                        $arrayPrices[$arrayOfDates[$d]]['pi'] = $price['updated_at'];
                    }
                }
            }
        }

        //Create Chart Data
        $chart_data = "";
        foreach($arrayPrices as $day => $price) {
            $chart_data .= "['".$day."',  ".$price['price'].", ".$price['price_2']."],";
        }
        $chart_data = substr($chart_data,0,-1);

        return $chart_data;
    }

}
