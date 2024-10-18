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
class SilverOverdraft implements OverdraftInterface
{
    const OVERDRAFT_AMOUNT = 100 ;
  public function isGrantOverdraftFunds(float $balance): bool{
    return 0 >= ($balance + self::OVERDRAFT_AMOUNT);
  }

  public function getOverdraftFundsAmount() : float{
    return self::OVERDRAFT_AMOUNT;
  }

}