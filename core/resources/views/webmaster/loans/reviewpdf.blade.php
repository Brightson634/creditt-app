<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>fkjfgd</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
   <style media="all">
        /*@page {
         margin: 0;
         padding:0;
      }*/
      .header {
        margin: 0;
         padding:0;
      }
      body{
         font-size: 0.875rem;
            font-family: 'Helvetica';
            font-weight: normal;
            
            
         padding:0;
         margin:0; 
      }
      .gry-color *,
      .gry-color{
         color:#000;
      }
      table{
         width: 100%;
      }
      table th{
         font-weight: normal;
      }
      table.padding th{
         padding: .25rem .7rem;
      }
      table.padding td{
         padding: .25rem .7rem;
      }
      table.sm-padding td{
         padding: .1rem .7rem;
      }
      .border-bottom td,
      .border-bottom th{
         border-bottom:1px solid #eceff4;
      }
      .text-left{
         text-align:left;
      }
      .text-right{
         text-align: right;
      }

      .strong {
         font-weight: bold;
      }

      .dotted-line {
/*         border-bottom: 1px dotted black;*/
         border-bottom:2px solid #eceff4;
      }

      .myw {
            width: 350pt;
             line-height: 15pt;
        }

        .myw h2 {
            font-size: 18pt;
             line-height: 20pt;
        }

        .myw p {
            font-size: 12pt;
           
        }
        .base-color {
         color: red;
        }
   </style>
</head>
<body>
   <div>

<div class="header" style="margin: 0;
         padding:0;">
   <div style="background: #eceff4;padding: 1rem; margin-left: -4.4rem; margin-right:-4.4rem; margin-top: -20rem">
      <table>
         <tr>
            <td class="myco text-center">
               <img src="{{ asset('assets/uploads/generals/'. $gs->logo ) }}">
            </td>
            <td class="myw">
               <table>
                  <tbody>
                     <tr>
                        <th class="gry-color base-color text-right"> <h2>Nsoloolo Savings Group Sacco</h2></th>
                     </tr>
                     <tr>
                        <th class="gry-color text-right"> <p>Earn | Save | Invest | Earn</p></th>
                     </tr>
                  </tbody>
               </table>
               <table>
                  <tbody>
                     <tr>
                        <th class="gry-color text-right">P.O Box 2324 Kampala - Uganda</th>
                     </tr>
                     <tr>
                        <th class="gry-color text-right">UK MALL Kansanga along Ggaba Road</th>
                     </tr>
                     <tr>
                        <th class="gry-color text-right">+256 772343222, +256 772343222, +256 772343222</th>
                     </tr>
                     <tr>
                        <th class="gry-color text-right">nsoloolo@gmail.com | pepepas@gmail.com</th>
                     </tr>
                     <tr>
                        <th class="gry-color text-right">www.nsoloolo.com</th>
                     </tr>
                  </tbody>
               </table>
            </td>
        </tr>
      </table>
   </div>
</div>

   <h2 align="center">{{ $title }}</h2>

         <h3>General Information</h3>
   <div style="padding: 1rem;padding-bottom: 0">      
      <table>
      @if($loan->loan_type == 'individual')
      <tr>
         <td>Member: {{ $loan->member->title }} {{ $loan->member->fname }} {{ $loan->member->lname }} {{ $loan->member->oname }}</td>
      </tr>
      @endif
      @if($loan->loan_type == 'group')
      <tr>
         <td>Group: {{ $loan->member->fname }}</td>
      </tr>
      @endif
      <tr>
         <td>Loan Product: {{ $loan->loanproduct->name }}</td>
      </tr>
      <tr>
         <td>Interest Rate: {{ $loan->loanproduct->interest_rate }}% / 
            @if($loan->loanproduct->duration == 'day') DAY 
            @elseif($loan->loanproduct->duration == 'week') WEEK  
            @elseif($loan->loanproduct->duration == 'month') MONTH  
            @endif</td> 
      </tr>
      <tr>
         <td>Loan Period: {{ $loan->loan_term }} 
            @if($loan->loanproduct->duration == 'day') days 
            @elseif($loan->loanproduct->duration == 'week') weeks  
            @elseif($loan->loanproduct->duration == 'month') months  
            @endif</td>
      </tr>
      <tr>
         <td>Release Date: {{ dateFormat($loan->release_date) }}</td>
      </tr>
      <tr>
         <td>Repayment Date: {{ dateFormat($loan->repayment_date) }}</td>
      </tr>
      <tr>
         <td>Loan End Date: {{ dateFormat($loan->end_date) }}</td>
      </tr>
   </table>
</div>
   
   <div style="padding: 1rem;padding-bottom: 0"> 
   <table>
         <tr>
            <th align="center">Principal Amount</th>
            <th align="center">Interest Amount</th>
            <th align="center">Loan Amount</th>
            <th align="center">Loan Charges</th>
         </tr>
      <tr  class="item1">
            <td align="center">{!! showAmountPdf($loan->principal_amount) !!}</td>
            <td align="center">{!! showAmountPdf($loan->interest_amount) !!}</td>
            <td align="center">{!! showAmountPdf($loan->repayment_amount) !!}</td>

            <td align="center">{!! showAmountPdf($loan->fees_total) !!}</td>

            </tr>
    </table>
 </div>



   <div style="padding: 1rem;">
      <h3>Loan Charges</h3>
   <table class="padding text-left small">
      <tr>
         <th class="text-left">#</th>
         <th class="text-left">Detail</th>
         <th class="text-left">Amount</th>
         <th class="text-left">Account No</th>
      </tr>
         @php $i = $total_charges = 0; @endphp
         @foreach($loancharges as $row)
         @php 
         $total_charges += $row->amount;
         $i++; 
         @endphp
         <tr class="item">
            <td>{{ $i }}</td>
            <td>{{ $row->detail }}</td>
            <td> {!! showAmountPdf($row->amount) !!}</td>
            <td>@if($row->account_id != NULL) {{ $row->account->account_no }}  @else -  @endif </td>
         <tr>
         @endforeach
         <tfoot>
            <tr>
               <td></td>
               <td><strong>Total</strong></td>
               <td><strong>{!! showAmount($total_charges) !!}</strong></td>
               <td></td>
            </tr>
         </tfoot>
      </table>
   </div>

   <div style="padding: 1rem;">
         <h3>Loan Guarantors</h3>
   <table class="padding text-left small">
      <tr>
         <th class="text-left">#</th>
                              <th class="text-left">Names</th>
                              <th class="text-left">Email</th>
                              <th class="text-left">Telephone</th>
                              <th class="text-left">Address</th>
                              <th class="text-left">Remark</th>
      </tr>
         @php $i = 0; @endphp
                           @foreach($guarantors as $row)
                           @php $i++;  @endphp
                           <tr class="item">
                              <td>{{ $i }}</td>
                              @if($row->is_member == 1)
                                 <td>
                                    @if($row->member->member_type == 'individual') {{ $row->member->title }} {{ $row->member->fname }} {{ $row->member->lname }} @endif
                                    @if($row->member->member_type == 'group') {{ $row->member->fname }} @endif
                                 </td>
                                 <td>{{ $row->member->email }}</td>
                                 <td>{{ $row->member->telephone }}</td>
                                 <td>{{ $row->member->address }}</td>
                                 <td>Member</td>
                              @endif
                              @if($row->is_member == 0)
                                 <td>{{ $row->name }}</td>
                                 <td>{{ $row->email }}</td>
                                 <td>{{ $row->telephone }}</td>
                                 <td>{{ $row->address }}</td>
                                 <td>Non Memeber</td>
                              @endif
                           <tr>
                           @endforeach
      </table>
   </div>

    <div style="padding: 1rem;">
              <h3>Loan Collaterals</h3>
   <table class="padding text-left">
      <tr>
         <th class="text-left">#</th>
                              <th class="text-left">Item</th>
                              <th class="text-left">Collateral Name</th>
                              <th class="text-left">Estimate Value</th>
      </tr>
        @php $i = $total_costs = 0; @endphp
                           @foreach($collaterals as $row)
                           @php 
                           $i++;
                           $total_costs += $row->estimate_value;
                           @endphp
         <tr class="item">
            <td>{{ $i }}</td>
                              <td>{{ $row->item->name }}</td>
                              <td>{{ $row->name }}</td>
                              <td>{!! showAmount($row->estimate_value) !!}</td>
         <tr>
         @endforeach
         <tfoot>
                           <tr>
                              <td></td>
                              <td><strong>Total</strong></td>
                              <td></td>
                              <td><strong>{!! showAmount($total_costs) !!}</strong></td>
                           </tr>
                        </tfoot>
      </table>
   </div>

  <!--  <table class="mt-80">
  <tr>
    <td class="regards">Thanks & Regards</td>
  </tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr>
    <td class="name">Mayanja John</td>
    <td class="regards dotted-line">--------------------------------------</td>
  </tr>
  <tr>
    <td class="strong regards">Position</td>
  </tr>
</table> -->

@if($officers->count() > 0)
@foreach($officers as $row)
   <div style="padding: 1rem;">
      <table class="padding text-left"  style="padding-bottom: 2rem;">
         <tr>
            <th align="text-left">Comments</th>
         </tr>
         <tr>
            <td align="text-left">{{ $row->comment }}</td>
         </tr>

      </table>
      <table class="padding text-left">
         <tr>
            <th align="text-left">Name</th>
            <th align="text-left">Signature</th>
            <th align="text-left">Date</th>
         </tr>
         <tr class="item1">
            <td align="text-left" style="margin-bottom: -20rem;">{{ $row->staff->title }} {{ $row->staff->fname }} {{ $row->staff->lname }} {{ $row->staff->oname }}</td>
            <td align="text-left">
               <img alt="image" src="{{ asset('assets/uploads/staffs/'. $row->staff->signature )}}" width="100" alt="signature" />
            </td>
            <td align="text-left">{{ dateFormat($row->date) }}</td>
         </tr>
         <tr class="item1">
            <td align="text-left" style="margin-top: -20rem;">---------------------------------------</td>
            <td align="text-left">---------------------------------------</td>
            <td align="text-left">---------------------------------------</td>
         </tr>
      </table>
   </div>
   @endforeach
@endif



   </div>
</body>
</html>