@extends('layouts.app')

@section('content')
    <div class="container-full">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-3">
                                {!! $accountSelect !!}
                            </div>
                            <div class="col mb-1 mt-1 mb-md-0 mt-md-0">

                            </div>
                            <div class="col-sm-12 col-md-2 text-right">
                                <button class="btn btn-primary btn-block" type="button" data-toggle="modal" data-target="#transaction-modal">Manage</button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="alert alert-secondary mb-0 d-none" role="alert" id="loading-spinner">
                                <p class="mb-0 pb-0">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...
                                </p>
                            </div>

                        </div>

                        <div class="row">
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
