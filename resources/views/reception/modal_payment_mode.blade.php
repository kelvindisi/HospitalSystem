<div class="modal fade" id="paymentModeModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLable">
                    Mode Of Payment
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('add_consult', ['patient'=>$patient->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="paymentMode col-12">Mode of Payment</label>
                        <select name="payment_mode" id="paymentMode" class="form-control">
                            <option selected>Choose option</option>
                            @foreach($modes as $mode)
                            <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-success">
                            <i class="fas fa-plus"></i>
                            <span>Add</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p><small class="text-muted"> &copy; {{ config('APP_NAME') }} Copyright </small></p>
            </div>
        </div>
    </div>
</div>