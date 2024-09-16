@include('webmaster.receipts.header')
<!-- Customer and Transaction Info --> 
<table class="table table-striped info-table">
    <tbody>
        <tr>
            <th>Deposit Date:</th>
            <td>{{ $deposit->date }}</td>
        </tr>
        <tr>
            <th>Account Holder:</th>
            <td>{{ $memberName }}</td>
        </tr>
        <tr>
            <th>Telephone No:</th>
            <td>{{$member->telephone}}</td>
        </tr>
        <tr>
            <th>Account Number:</th>
            <td>{{ $deposit->memberAccount->account_no }}</td>
        </tr>
        <tr>
            <th>Payment Type:</th>
            <td>{{ $deposit->paymenttype->name }}</td>
        </tr>
        <tr>
            <th>Deposited By:</th>
            <td>{{ ucfirst(strtolower($deposit->depositor)) }}</td>
        </tr>
        <tr>
            <th>Processed By:</th>
            <td>{{ ucfirst(strtolower(webmaster()->fname)) . ' ' . ucfirst(strtolower(webmaster()->lname)) }}</td>
        </tr>
        <tr>
            <th>Deposit Amount:</th>
            <td>UGX {{ number_format($deposit->amount, 2) }}</td>
        </tr>
    </tbody>
</table>

@include('webmaster.receipts.footer')
