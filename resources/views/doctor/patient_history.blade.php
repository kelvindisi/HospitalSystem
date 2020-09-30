<div class="modal fade" id="patientHistory" tabindex="-1" role="dialog" aria-labelledby="PatientHistory" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Patient History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($consultation->patient->consultations->count() > 1)
                    <?php $counter = 1; ?>
                    @foreach($consultation->patient->consultations as $loopConsul)

                        @if ($consultation->id != $loopConsul->id)
                        <hr>
                        <div class="col-12">
                            <p><span class="bold">{{ $counter }}. </span><span class="text-muted">Date: </span> {{ $loopConsul->created_at }}</p>
                        </div>
                        <div class="col-12">
                                <p>
                                    <span class="text-muted">Diagnosis:</span>
                                    {{ $loopConsul->diagnosis }}
                                </p>
                        </div>
                        <div class="col-12">
                            <p class="text-muted"
                            >Consultation completed: @if($loopConsul->status == 'seen'){{__('Yes')}}@else{{ __('No') }}@endif</p>
                        </div>
                        <hr>
                        @endif
                        <?php $counter = $counter + 1 ?>
                    @endforeach
                @else
                <p class="bold h4">Patient has no previous history</p>
                @endif
            </div>
        </div>
    </div>
</div>
