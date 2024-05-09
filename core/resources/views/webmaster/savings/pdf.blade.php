<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Purchase Invoice</title>
    <style>
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
        color: #0087C3;
        text-decoration: none;
    }

    body {
        position: relative;
        /*width: 21cm;*/
        height: 29.7cm;
        margin: 0 auto;
/*        color: #555555;*/
        background: #FFFFFF;
/*        font-family: Arial, sans-serif;*/
        font-size: 18px;
        font-family: 'Helvetica';
        /*font-family: 'Hind Siliguri', sans-serif;*/
    }

    .float-left{
        float: left;
    }

    header {
        padding: 5px 0;
        margin-bottom: 10px;
    }

    #logo {
        float: left;
        margin-top: 0px;
        width: 40%;
    }

    #logo img {
        height: 70px;
    }

    .header-company-info{
        float: right;
        text-align: right;
        width: 60%;
    }

    .header-company-info-sell-invoice{
        text-align: center;
    }

    .border-bottom{
        border-bottom: 1px solid #AAAAAA;
    }


    #details {
        margin-bottom: 50px;
    }

    #client {
        padding-left: 6px;
        border-left: 6px solid #0087C3;
        float: left;
    }

    #client .to {
        color: #777777;
    }

    h2.name {
        font-size: 1.4em;
        font-weight: normal;
        margin: 0;
        text-align: center;
    }

    #invoice {
        float: right;
        text-align: right;
    }

    #invoice h1 {
        color: #0087C3;
        font-size: 2.4em;
        line-height: 1em;
        font-weight: normal;
        margin: 0  0 10px 0;
    }

    #invoice .date {
        font-size: 1.1em;
        color: #777777;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        font-size: 11px;
    }

    table th,
    table td {
        padding: 3px;
        border-bottom:1px solid #eceff4;
    }

    table th {
        font-weight: normal;
/*        text-align: center;*/
    }

    table td {
/*        text-align: center;*/
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    #thanks{
        font-size: 2em;
        margin-bottom: 50px;
    }

    #notices{
        padding-left: 6px;
        border-left: 6px solid #0087C3;
    }

    #notices .notice {
        font-size: 1.2em;
    }

   footer {
      color: #777777;
      width: 120%;
      position: absolute;
      bottom: 0;
      margin-bottom: 45px;
      margin-left: -3rem;  
/*    margin-bottom: -3rem*/
      text-align: center;
      background: #eceff4;
    }
   footer p {
      font-size: 12px;
   }

    .mt-10{
        margin-top: 10px;
    }
    .bg-secondary {
        background-color: #eceff4 !important;
    }

    .text-white {
        color: #fff !important;
    }

    .text-right {
        text-align: right !important;
    }
    .text-left{
        text-align: left !important;
    }

    .myw {
            width: 300pt;
             line-height: 14pt;
        }

        .myw h2 {
            font-size: 18pt;
        }

        .myw p {
            font-size: 13pt;
           
        }
</style>
</head>
<body >

<header class="clearfix">
   <div style="background: #eceff4;padding: 1rem; margin-left: -3rem; margin-right:-3rem; margin-top: -3rem">
      <table>
         <tr>
            <td class="myco text-center">
               <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
            </td>
            <td class="myw">
               <table>
                  <tbody>
                     <tr>
                        <th class="gry-color text-right"><h2>Nsoloolo Savings Group Sacco</h2></th>
                     </tr>
                     <!-- <tr>
                        <th class="gry-color text-right">Earn | Save | Invest | Earn</th>
                     </tr> -->
                     <tr>
                        <th class="gry-color text-right">{!! nl2br($gs->address) !!}</th>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </table>
   </div>
</header>

<main>
   <div style="padding: 10px;">
      <h2 class="name">Member Savings</h2>
   </div>

   <div class="table-responsive" style="padding-top: 10px;">
      <table class="table" width="100%" cellspacing="0">
         <thead>
            <tr class="bg-secondary">
               <th class="text-left"><strong>#</strong></th>
               <th class="text-left"><strong>pages.product</strong></th>
               <th class="text-left"><strong>pages.unit_price</strong></th>
               <th class="text-left"><strong>pages.quantity</strong></th>
               <th class="text-left"><strong>pages.total_price</strong></th>
            </tr>
         </thead>
         <tbody>
            @php $i = 0; @endphp
            @foreach($savings as $row)
            @php $i++; @endphp
            <tr>
               <td>{{ $i }}</td>
               <td>{{ $row->member->fname }} {{ $row->member->lname }}</td>
               <td>{!! showAmountPdf($row->deposit_amount) !!}</td>
               <td> {{ $row->account->account_no }}</td>
               <td>{!! showAmountPdf($row->current_balance) !!}</td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</main>

<footer>
   <p>
    Creditt Systems, Kampala - Uganda , +256 759218758
 </p>
</footer>
</body>
</html>
