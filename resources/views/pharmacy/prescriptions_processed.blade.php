<div class="table-responsive">
    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Issued</th>
                <th>Issue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->prescriptions as $prescription)
            <tr>
                <td> {{ $prescription->drug->name }} </td>
                <td> {{ $prescription->quantity }} </td>
                <td> {{ ucfirst(trans($prescription->availability)) }} </td>
                <td> @if($prescription->issued){{_('Yes')}}@else{{_('No')}}@endif</td>
                <td>
                    <?php $issued = $prescription->issued ?>
                   <form action="{{ route('pharmacy.issue', $prescription->id) }}" method="post">
                       @csrf
                        <input type="hidden" name="_method" value="put">
                        <button class="btn btn-sm btn-@if($issued){{_('danger')}}@else{{_('success')}}@endif">
                            @if($issued)
                            <i class="fas fa-check"></i>
                            <span>Issue</span>
                            @else
                            <i class="fas fa-check"></i>
                            <span>Not Issued</span>
                            @endif
                        </button>
                   </form>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>