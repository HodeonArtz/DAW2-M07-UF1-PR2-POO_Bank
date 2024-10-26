<?php namespace ComBank\OverdraftStrategy;
      use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 12:27 PM
 */

class NoOverdraft implements OverdraftInterface
{
  const OVERDRAFT_AMOUNT = 0 ;
  const INTEREST_RATE = 0;

  public function isGrantOverdraftFunds(float $balance): bool{
    return 0 <= (self::OVERDRAFT_AMOUNT + $balance);
  }

  public function getOverdraftFundsAmount() : float{
    return self::OVERDRAFT_AMOUNT;
  }
  
  function getInterestRate(): float{
    return self::INTEREST_RATE;
  }
}