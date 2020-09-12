@if ($staff->roles()->count() > 0)
    <?php $role = $staff->roles()->first()->name; ?>
    @switch($role)
        @case('admin')
            <p><strong>Role:</strong> Administrator</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>Add Staff</li>
                <li>Activate/Deactivate Staff</li>
                <li>Add Admins</li>
                <li>Reset Staff password</li>
            </ul>
            @break
        @case('receptionist')
            <p><strong>Role:</strong> Receiptionist</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>Register Patients</li>
                <li>Add Patients to Consultation List</li>
                <li>Remove patients from consultation list if no charges paid yet</li>
                <li>Send message to Administrator</li>
            </ul>
            @break
        @case('doctor')
            <p><strong>Role:</strong> Doctor</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>See Patient treatment history</li>
                <li>Request lab test</li>
                <li>View Lab Results</li>
                <li>Issue prescription</li>
            </ul>
            @break
        @case('finance')
            <p><strong>Role:</strong> Finance/Accountant</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>See Invoice status</li>
                <li>Change invoice status</li>
                <li>See patient invoice history</li>
            </ul>
            @break
        @case('laboratory')
            <p><strong>Role:</strong> Laboratory</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>See requested test(s)</li>
                <li>Record test results</li>
            </ul>
            @break
        @case('pharmacy')
            <p><strong>Role:</strong> Pharmacy</p>
            <p><strong>Responsibilities:</strong></p>
            <ul>
                <li>See prescription list(s)</li>
                <li>Change prescription state (issued, not issue, pending)</li>
            </ul>
            @break
    @endswitch
@else
    <p class="h5">Ooooohpps! looks like user is not assigned a role</p>
@endif
<p>You can assign or change the role here:</p>

<form action="{{ route('add_role') }}" method="post" class="form-inline">
    @csrf
    <input type="hidden" name="staff_id" value="{{ $staff->id }}">
    <div class="form-group">
        <label for="role">Role:</label>
        <select name="role_id" id="role" class="form-control">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
        </select>
        
    </div>
    <div class="form-group">
        <button class="btn btn-sm btn-outline-primary">Add</button>
    </div>
</form>