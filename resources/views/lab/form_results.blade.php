<form action="{{ route('lab.result_save', $rqTest->id) }}" method="post">
    @csrf
    <div class="form-group">
        <label for="result">Result</label>
        <textarea name="result" id="result"
                  cols="30"
                  rows="10"
                  class="form-control @error('result'){{ __('is-invalid') }}@enderror"
        >@if($rqTest->test_result){{ $rqTest->test_result->result }}@endif</textarea>
        @error('result')
            <small class="text-danger">{{$message}}</small>
        @enderror
    </div>
    <div class="form-group text-right">
        <button class="btn btn-primary">
            @if(!$rqTest->test_result)
                {{ __('Save') }}
            @else
                {{ __('Update') }}
            @endif
        </button>
    </div>
</form>
