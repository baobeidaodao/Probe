<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: view.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 06:08:00
 */
?>

<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="card">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ $user->name or '' }}</li>
                    <li class="list-group-item">{{ $user->email or '' }}</li>
                    <li class="list-group-item">
                        <ul class="list-group list-group-flush">
                            @foreach($user->roles as $role)
                                <li class="list-group-item">
                                    {{ $role->display_name or $role->name }}
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <ul class="list-group list-group-flush">
                            @foreach($user->roles as $role)
                                @foreach($role->perms as $perm)
                                    <li class="list-group-item">
                                        {{ $perm->display_name or $perm->name }}
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
</div>
