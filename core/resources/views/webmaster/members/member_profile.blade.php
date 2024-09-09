<div class="col-md-8">
    <div class="card">
        <div class="card-header text-center">
            <h2>Member Profile</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <input type='hidden' value="{{ $memberDetails->fname.' '.$memberDetails->lname}}" id='memberName'>
                <div class="col-md-4 text-center">
                    @if ($memberDetails->photo != null)
                            <img alt="image" id="pp_preview2"
                                src="{{ asset('assets/uploads/members/' . $memberDetails->photo) }}"
                                 class="img-fluid rounded-circle" alt="Profile Picture" width="150" />
                        @else
                            <img alt="image" id="pp_preview2" src="{{ asset('assets/uploads/defaults/author.png') }}"
                                width="140" class="avatar img-thumbnail" alt="avatar">
                        @endif
                </div>
                <div class="col-md-8">
                    <!-- Member Details -->
                    <h3>{{ $memberDetails->title.'.'.$memberDetails->fname.' '.$memberDetails->lname}}</h3>
                    <p><strong>Account Number:</strong> {{ $memberAcc->account_no }}</p>
                    <p><strong>Email:</strong>{{ $memberDetails->email }}</p>
                    <p><strong>Phone:</strong> {{ $memberDetails->telephone}}</p>
                    <p><strong>Occupation:</strong> {{ ucwords($memberDetails->occupation)}}</p>
                    <p><strong>ID Number:</strong> {{$memberDetails->nin}}</p>
                    <p><strong>Current Address:</strong> {{ $memberDetails->current_address}}</p>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <span> Signature:</span>
        </div>
    </div>
</div>
