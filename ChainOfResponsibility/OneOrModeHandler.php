<?php


abstract class CashProvider {

    protected $value;
    /**
     * @var CashProvider
     */
    protected $cashProvider;

    public function nextProvider(CashProvider $cashProvider){
        $this->cashProvider = $cashProvider;
    }

    function getCash(int $requestedAmount)
    {
        $nbBill = (int) ($requestedAmount / $this->value);

        echo(__CLASS__." provides \033[01;31m". $nbBill . "\033[0m   *  \033[00;32m".$this->value."\033[0m bill(s) \n");

        $pendingCash = $requestedAmount % $this->value;

        if ($pendingCash > 0) {
            $this->cashProvider->getCash($pendingCash);
        }
    }
}


class HundredsProvider extends CashProvider {

    protected $value = 100;

}


class FiftiesProvider extends CashProvider {

    protected $value = 50;

}

class TwentiesProvider extends CashProvider {

    protected $value = 20;

}

class FivesProvider extends CashProvider {

    protected $value = 5;

}

class OnesProvider extends CashProvider {

    protected $value = 1;

}



class ATM {

    protected $hundredsProvider;
    protected $fiftiesProvider;
    protected $twentiesProvider;
    protected $fivesProvider;
    protected $onesProvider;

    function __construct()
    {
        $this->hundredsProvider = new HundredsProvider();
        $this->fiftiesProvider  = new FiftiesProvider();
        $this->twentiesProvider = new TwentiesProvider();
        $this->fivesProvider    = new FivesProvider();
        $this->onesProvider     = new OnesProvider();

        $this->hundredsProvider->nextProvider($this->fiftiesProvider);
        $this->fiftiesProvider->nextProvider($this->twentiesProvider);
        $this->twentiesProvider->nextProvider($this->fivesProvider);
        $this->fivesProvider->nextProvider($this->onesProvider);
    }

    function pickUpCash(int $amount){

        echo("\n ******** Retrieving ". $amount. " $ from ATM ******** \n \n");
        $this->hundredsProvider->getCash($amount);
    }

}




//////////// DISPLAY //////////


$atm = new ATM();

$atm->pickUpCash(1489);