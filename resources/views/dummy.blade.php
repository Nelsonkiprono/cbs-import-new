@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Loan Amount</th>
                  <th scope="col">Loan Interest</th>
                  <th scope="col">Loan %</th>
                  <th scope="col">Start Date</th>
                  <th scope="col">End Date</th>
                  <th scope="col">Phone No</th>
                </tr>
              </thead>
              <tbody>
                @foreach($loans as $loan)
                <tr>
                  <th scope="row">{{ $loan->trans_no }}</th>
                  <td>{{ $loan->client_name  }}</td>
                  <td>{{ $loan->amount  }}</td>
                  <td>{{ $loan->interest  }}</td>
                  <td>{{ $loan->perc  }}</td>
                  <td>{{ $loan->start_date  }}</td>
                  <td>{{ $loan->end_date  }}</td>
                  <td>{{ $loan->phone  }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
