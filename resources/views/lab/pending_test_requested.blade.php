<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Test Name</th>
                <th>Doable</th>
                <th>Change To</th>
            </tr>
        </thead>
        <tbody>
            @foreach($consultation->requested_tests as $rqTest)
            <tr>
                <td>{{ $rqTest->test->name }}</td>
                <td>{{ ucfirst(trans($rqTest->doable)) }}</td>
                <td>
                    <?php $doable = $rqTest->doable; ?>
                    <form action="{{ route('lab.updateDoability', $rqTest->id) }}" class="form-inline" method="post">
                        @csrf
                        <div class="form-group">
                            <select class="form-control" name="doable" id="doable">
                                <option value="pending">Pending</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="ml-2 btn btn-primary">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>