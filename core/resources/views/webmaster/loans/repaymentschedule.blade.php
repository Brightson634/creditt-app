<style>
    .repaymentTable thead tr th {
        color:white !important;
    }
</style>
<table class='table table-striped table-responsive repaymentTable'>
  <thead style="background-color: #596882">
    <tr>
      <th style="color:white">INSTALLMENT NUMBER</th>
      <th>PAYMENT DATE</th>
      <th>INSTALLMENT AMOUNT</th>
      <th>INTEREST IN PAYMENT</th>
      <th>PRINCIPAL PAID</th>
      <th>ENDING PERIOD BALANCE</th>
    </tr>
  </thead>
  <tbody>
    <?php for($j=0;$j<$totalLoanData['numberOfPeriods'];$j++):?>
    <tr>
      <td>#<?=$periodData['period'][$j];?></td>
      <td><?=$periodicPaymentDates['dates'][$j];?></td>
      <td><?=$installmentAmountData['periodicInstallment'][$j]?></td>
      <td><?=$interestAmountData['interestAmount'][$j]?></td>
      <td><?=$amountInPaymentOfPrincipalData['principalPaid'][$j]?></td>
      <td><?=$endOfPeriodOutStandingBalanceData['remainingPrincipal'][$j]?></td>
    </tr>
    <?php endfor;?>
  </tbody>
</table>
