<div class="modal fade" id="showUser" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User</h5>
                <a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        @if($user->is_verified == 0)
                            @isset($user->student->id)
                            <label>School ID:</label><br>
                            <img class="img-thumbnail" src="{{ asset($user->schoolID_image()) }}" alt="">
                            @endif
                        @endif
                        <label>Role:</label>
                        {{ $user->role->role->name }}
                        <br>
                        <label for="email">Email:</label>
                        {{ $user->email }}
                        <br>
                        <label for="username">Username:</label>
                        {{ $user->username }}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col">
					@if ($user->trashed())
                		@can('users.restore')
					    <a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download"></i> Restore</a>
						@endcan
					@else
						@can('users.destroy')
					    <a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
						@endcan
					@endif
					@can('users.edit')
					   <a class="btn btn-default text-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-href="{{ route('users.edit', $user->id) }}" data-target="#editDoctorsNotes"><i class="fad fa-edit"></i> Edit</a>
                    @endcan
                    @if($user->is_verified == 0)
					   <a class="btn btn-default text-success" href="{{ route('users.activate', $user->id) }}" ><i class="fad fa-unlock"></i> Activate</a>
                    @endif
				</div>
				<div class="col-3 text-right">
					<button class="btn btn-default" type="button" data-dismiss="modal-ajax"> Close</button>
				</div>
            </div>
        </div>
    </div>
</div>
    