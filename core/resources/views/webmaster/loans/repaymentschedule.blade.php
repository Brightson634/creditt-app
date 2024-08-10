<style>
    .repaymentTable thead tr th {
        color:black !important;
    }
</style>
<div class="card card-dashboard-table-six">
  <div class="table-responsive">
    <table class='table table-striped repaymentTable'>
      <thead style="background-color: #596882">
        <tr>
          <th>INSTALLMENT NUMBER</th>
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
  </div>
</div>
