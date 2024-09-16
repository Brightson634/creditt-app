@include('webmaster.receipts.header')
<!-- Customer and Transaction Info --> 
<table class="table table-striped info-table">
    <tbody>
        <tr>
            <th>Transaction Date:</th>
            <td>{{ $transfer->date }}</td>
        </tr>
        <tr>
            <th>Sender's Account Holder:</th>
            <td>{{ $senderName }}</td>
        </tr>
        <tr>
            <th>Sender's Account Number:</th>
            <td>{{ $transfer->debitaccount->account_no }}</td>
        </tr>
        <tr>
            <th>Receiver's Account Holder:</th>
            <td>{{ $receiverName }}</td>
        </tr>
        <tr>
            <th>Receiver's Account Number:</th>
            <td>{{ $transfer->creditaccount->account_no }}</td>
        </tr>
        {{-- <tr>
            <th>Payment Type:</th>
            <td>{{ $transfer->paymenttype->name }}</td>
        </tr> --}}
        <tr>
            <th>Processed By:</th>
            <td>{{ ucfirst(strtolower(webmaster()->fname)) . ' ' . ucfirst(strtolower(webmaster()->lname)) }}</td>
        </tr>
        <tr>
            <th>Transfer Amount:</th>
            <td>UGX {{ number_format($transfer->amount, 2) }}</td>
        </tr>
    </tbody>
</table>
@include('webmaster.receipts.footer')
