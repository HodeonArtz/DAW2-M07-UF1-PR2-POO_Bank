<?php namespace ComBank\OverdraftStrategy;
      use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:39 PM
 */

/**
 * @description: Grant 100.00 overdraft funds.
 * */
class BasicOverdraft implements OverdraftInterface
{
    const OVERDRAFT_AMOUNT = 50;
    const INTEREST_RATE = 0.05;

  public function isGrantOverdraftFunds(float $balance): bool{
    return 0 <= (self::OVERDRAFT_AMOUNT + $balance);
  }

  public function getOverdraftFundsAmount() : float{
    return self::OVERDRAFT_AMOUNT;
  }

}