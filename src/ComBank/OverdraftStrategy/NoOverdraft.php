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

  public function isGrantOverdraftFunds(float $balance): bool{
    return $balance >= self::OVERDRAFT_AMOUNT;
  }

  public function getOverdraftFundsAmount() : float{
    return self::OVERDRAFT_AMOUNT;
  }
   
}