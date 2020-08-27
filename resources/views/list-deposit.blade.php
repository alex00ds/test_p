@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Your Deposits') }}</div>

                <div class="card-body p-0">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Invested</th>
                        <th>Percent</th>
                        <th>Duration</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($deposits as $deposit)
                      <tr>
                        <td>{{ $deposit->id }}</td>
                        <td>{{ number_format($deposit->invested, 2) }}</td>
                        <td>{{ $deposit->percent }}%</td>
                        <td>{{ $deposit->duration }}</td>
                        <td>{{ number_format($deposit->balance, 2) }}</td>
                        <td>{{ $deposit->active ? 'active' : 'closed' }}</td>
                        <td>{{ $deposit->created_at->format(config('view.date_format')) }}</td>
                      </tr>
                      @empty
                      <tr>
                        <td colspan="7">There are no deposits</td>
                      </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        {{ $deposits->links() }}
    </div>
</div>
@endsection
