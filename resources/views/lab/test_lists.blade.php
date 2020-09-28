<?php
$tests = $consultation->requested_tests;
?>

<div class="table-responsive">
    <table class="table table-striped" id="dataTable">
        <thead>
            <tr>
                <th>Test</th>
                <th>Paid</th>
                <th>Done</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tests as $rqTest)
            <tr>
                <td>{{ $rqTest->test->name }}</td>
                <td>
                    @if($rqTest->test_invoice->paid == 'yes')
                        {{ __('Paid') }}
                    @else
                        {{ __('Not Paid') }}
                    @endif
                </td>
                <td>@if($rqTest->test_result){{__('Yes')}}@else{{ __('No') }}@endif</td>
                <td>
                    @if($rqTest->test_invoice->paid == 'yes')

                        <a href="{{ route('lab.fillResults', $rqTest->id) }}"
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-edit"></i>
                            <span>Fill</span>
                        </a>

                    @else
                        <span class="test-danger"><i class="fas fa-ban"></i></span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
