<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-2">
        <strong>Name:</strong>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <span> {{ $consultation->patient->name }} </span>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-2">
        <strong>Gender:</strong>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <span> {{ ucfirst(trans($consultation->patient->gender)) }} </span>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-2">
        <strong>ID:</strong>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <span> {{ $consultation->patient->id_number }} </span>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-2">
        <strong>Phone:</strong>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4">
        <span> {{ $consultation->patient->phone }} </span>
    </div>
</div>