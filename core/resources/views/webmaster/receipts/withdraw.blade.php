@include('webmaster.receipts.header')

        <!-- Customer and Transaction Info -->
        <table class="table table-striped info-table">
            <tbody>
                <tr>
                    <th>Date:</th>
                    <td>{{ $withdraw->date }}</td>
                </tr>
                <tr>
                    <th>Account Holder:</th>
                    <td>{{$memberName }}</td>
                </tr>
                <tr>
                    <th>Account Number:</th>
                    <td>{{ $withdraw->memberAccount->account_no }}</td>
                </tr>
                <tr>
                    <th>Telephone No:</th>
                    <td>{{$member->telephone}}</td>
                </tr>
                <tr>
                    <th>Payment Type:</th>
                    <td>{{ $withdraw->paymenttype->name}}</td>
                </tr>
                
                <tr>
                    <th>Processed By:</th>
                    <td>{{ ucfirst(strtolower(webmaster()->fname)) . ' ' . ucfirst(strtolower(webmaster()->lname)) }}</td>
                </tr>
            </tbody>
        </table>
   <!-- Total Withdrawal Section -->
   <div class="total-section">
    Withdrawal Amount: UGX {{ generateComaSeparatedValue($withdraw->amount) }}
</div>
@include('webmaster.receipts.footer')