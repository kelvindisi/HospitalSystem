<div class="table-responsive">
    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Change availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->prescriptions as $prescription)
            <tr>
                <td> {{ $prescription->drug->name }} </td>
                <td> {{ $prescription->quantity }} </td>
                <td> {{ ucfirst(trans($prescription->availability)) }} </td>
                <td>
                    @if($prescription->availability == 'pending' || $prescription->availability =="no")
                    <a href="{{ route('pharmacy.pres_avail',['prescription' => $prescription]) }}" class="btn btn-outline-primary btn-sm">
                        <span>Available</span>    
                    </a>
                    @else
                    <a href="{{ route('pharmacy.pres_not_avail',['prescription' => $prescription]) }}" class="btn btn-outline-danger btn-sm">
                        <span>Not Available</span>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>