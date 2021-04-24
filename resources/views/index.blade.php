@extends('layouts.app')

@section('content')
    <div class="container-full">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-2">
                                {!! $accountSelect !!}
                            </div>
                            <div class="col text-right">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#transaction-modal">Manage</button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div id="account-container" class="col">
                                {!! $accountDetails !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @include('accounts.modals.new-transaction-modal')
@endsection
