<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Collateral Attachments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .collateral-card {
            margin-bottom: 30px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 10px;
        }

        .collateral-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .collateral-img-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .collateral-img-wrapper img {
            width: calc(33.333% - 10px);
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #fff;
        }

        .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }

        .collateral-details {
            padding: 10px 20px;
        }

        .total-cost {
            font-size: 1.25rem;
            font-weight: bold;
            text-align: right;
            padding: 15px;
            border-top: 2px solid #dee2e6;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center my-4">Loan Collateral Attachments</h2>

    @php
        $totalCost = 0;  // Initialize total cost variable
    @endphp

    @foreach ($collateralAttachments as $collateral)
    <div class="card collateral-card">
        <div class="card-header">
            Collateral Item: {{ $collateral->item->name }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 collateral-details">
                    <h5><strong>Collateral Name:</strong> {{ $collateral->name }}</h5>
                    <p><strong>Estimated Value:</strong> {{ format_number($collateral->estimate_value) }}</p>
                    <p><strong>Remarks:</strong> {{ $collateral->remarks }}</p>

                    @php
                        // Add this collateral's value to the total
                        $totalCost += $collateral->estimate_value;
                    @endphp
                </div>
                <div class="col-md-6">
                    <div class="collateral-img-wrapper">
                        @php
                            $photos = explode(',', $collateral->photo);
                        @endphp
                        @foreach ($photos as $photo)
                            <img src="{{ asset('assets/uploads/loans/' . trim($photo)) }}" alt="Collateral Image">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Display Total Estimated Cost -->
    <div class="total-cost">
        Total Estimated Value of Collaterals: {{ format_number($totalCost) }}
    </div>
</div>

</body>
</html>
