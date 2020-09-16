<form action="{{ route('doctor.diagnosisUpdate', ['consultation' => $consultation->id]) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="diagonis">Diagnosis</label>
        <textarea name="diagnosis" id="diagnosis" cols="30" rows="10" class="form-control"
        >@if(old('diagnosis')){{old('diagnosis')}}@else{{$consultation->diagnosis}}@endif</textarea>
    </div>
    <div class="form-group">
        <button class="btn btn-primary">
            <i class="fas fa-save"></i>
            <span>Save Diagnosis</span>
        </button>
    </div>
</form>