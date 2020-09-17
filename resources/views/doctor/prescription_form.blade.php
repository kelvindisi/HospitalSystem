<form action="{{ route('doctor.savePrescription', ['consultation'=>$consultation->id]) }}" method="post">
    @csrf
    <input type="hidden" name="drug" value="{{ $drug->id }}">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-2 col-md-1 text-right">
                <label for="quantity" class="bold">Quantity:</label>
            </div>
            <div class="col-sm-10 col-md-11">
                <input type="number" name="quantity" 
                    id="quantity" min="1"
                    class="form-control @error('quantity') is-invalid @enderror" 
                    style="max-width: 70px;"
                    required autocomplete="quantity"
                    value="@if(old('quantity')){{old('quantity')}}@elseif($prescribed){{$prescribed}}@endif">
            </div>
            @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div> 
    </div>
    <div class="form-group">
        <button class="btn btn-primary">Add Prescription</button>
    </div>
</form>