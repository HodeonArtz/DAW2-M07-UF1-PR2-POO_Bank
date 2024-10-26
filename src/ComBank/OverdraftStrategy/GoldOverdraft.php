<?php namespace ComBank\OverdraftStrategy;
      use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;

/**
 * Created by VS Code.
 * User: HodeonArtz
 * Date: 7/28/24
 * Time: 1:39 PM
 */

/**
 * @description: Grant 500.00 overdraft funds.
 * */
class GoldOverdraft implements OverdraftInterface
{
    const OVERDRAFT_AMOUNT = 500;
    const INTEREST_RATE = 0.01;
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