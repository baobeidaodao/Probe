<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: index.blade.php
 * Author  : Li Tao
 * DateTime: 2018-02-10 23:59:00
 */
?>

@extends('admin.index')

@section('main')
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-light">
            <tr>
                <th scope="col">id</th>
                <th scope="col">name</th>
                <th scope="col">email</th>
                <th scope="col">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#createUser">
                        Create
                    </button>
                    <div class="modal fade" id="createUser" tabindex="-1" role="dialog" aria-labelledby="createUserTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            @include('admin.users.create')
                        </div>
                    </div>
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id or 0 }}</th>
                    <td>{{ $user->name or '' }}</td>
                    <td>{{ $user->email or '' }}</td>
                    <td>
                        <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#viewUser{{ $user->id or 0 }}">
                            View
                        </button>
                        <div class="modal fade" id="viewUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="viewUser{{ $user->id or 0 }}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                @include('admin.users.view')
                            </div>
                        </div>
                        @ability('admin', 'edit_user', ['validate_all' => false,])
                        <button type="button" class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editUser{{ $user->id or 0 }}">
                            Edit
                        </button>
                        <div class="modal fade" id="editUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="editUser{{ $user->id or 0 }}Title" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                @include('admin.users.edit')
                            </div>
                        </div>
                        @endability
                        @if($user->name !== 'admin')
                            @permission('delete_user')
                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteUser{{ $user->id or 0 }}">
                                Delete
                            </button>
                            <div class="modal fade" id="deleteUser{{ $user->id or 0 }}" tabindex="-1" role="dialog" aria-labelledby="deleteUser{{ $user->id or 0 }}Title" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    @include('admin.users.delete')
                                </div>
                            </div>
                            @endpermission
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
