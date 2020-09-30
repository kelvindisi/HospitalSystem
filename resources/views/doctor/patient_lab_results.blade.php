<div class="modal fade" id="patientResults" tabindex="-1" role="dialog" aria-labelledby="PatientResults" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientResults">Patient Results</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($consultation->requested_tests)
                    @foreach($consultation->requested_tests as $rqTest)
                        <div class="col-12">
                            <p>
                                <span class="text-muted">Test:</span> {{ $rqTest->test->name }}
                            </p>
                            <hr>
                            @if ($rqTest->doable != 'yes')
                                <p class="h4 text-muted">Lab not able to perform the test.</p>
                            @else
                                @if (!$rqTest->test_invoice)
                                    <p class="h4 text-muted">Invoice processing issue</p>
                                @else
                                    @if ($rqTest->test_invoice->paid == 'pending')
                                        <p class="h5 text-primary">Waiting for payment processing</p>
                                    @elseif($rqTest->test_invoice->paid == 'no')
                                        <p class="h5 text-danger">Test not paid for.</p>
                                    @else
                                        @if ($rqTest->test_result)
                                            <p><span class="text-muted">Result:</span> {{ $rqTest->test_result->result }}</p>
                                        @else
                                            <p class="h5 text-primary">Test results not yet submitted</p>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="bold h5">Patients has no requested lab test for this consultation</p>
                @endif
            </div>
        </div>
    </div>
</div>
