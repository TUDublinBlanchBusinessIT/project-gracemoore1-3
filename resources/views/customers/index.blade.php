@extends('layouts.app')

@section('content')
  <div class="overflow-auto">
    <table>
     <thead>
       <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Most Recent Order #</th>
       </tr>
     </thead>
     <tbody>
     @foreach($customers as $cust)
       <tr>
        <td>{{ $cust->name }}</td>
        <td>{{ $cust->number }}</td>
        <td>
          {{ $cust->mostRecentOrder
               ? $cust->mostRecentOrder->id
               : '—' }}
        </td>
       </tr>
   @endforeach
  </tbody>
</table>


  </div>
@endsection

