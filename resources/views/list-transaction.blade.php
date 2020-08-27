@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Your Transactions') }}</div>

                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($transactions as $trans)
                      <tr>
                        <td>{{ $trans->id }}</td>
                        <td>{{ $trans->type }}</td>
                        <td>{{ number_format($trans->amount, 2) }}</td>
                        <td>{{ $trans->created_at->format(config('view.date_format')) }}</td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="4">There are no records</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                  
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        {{ $transactions->links() }}
    </div>
</div>
@endsection
