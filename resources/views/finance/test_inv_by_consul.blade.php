<div class="table-responsive">
    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Amount</th>
                <th>Paid</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->requested_tests as $rqTest)
            @if($rqTest->test_invoice)
            <tr>
                <td>{{ $rqTest->test->name }}</td>
                <td>{{ $rqTest->test_invoice->amount }}</td>
                <td>{{ ucfirst(trans($rqTest->test_invoice->paid)) }}</td>
                <td>
                    <a href="{{ route('test.setPaid', $rqTest->test_invoice->id) }}" class="btn btn-sm btn-outline-success">
                        <i class="fas fa-check"></i>
                        <span>Paid</span>
                    </a>
                    <a href="{{ route('test.setUnpaid', $rqTest->test_invoice->id) }}" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i>
                        <span>Not Paid</span>
                    </a>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
</div>
