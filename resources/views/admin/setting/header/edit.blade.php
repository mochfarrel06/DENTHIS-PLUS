@extends('layouts.master')

@section('title-page')
    Edit Header
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Header</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex">
                            <div class="d-flex align-items-center">
                                <i class="iconoir-table mr-2"></i>
                                <h3 class="card-title">Edit Header</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.header-setting.update') }}">
                                @csrf
                                @method('PUT')

                                <h5 class="font-bolder fs-4">Top Bar</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_email_icon">Icon Email</label>
                                            <input class="form-control" name="topbar_email_icon" value="{{ $setting->topbar_email_icon }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_email_text">Text Email</label>
                                            <input class="form-control" name="topbar_email_text" value="{{ $setting->topbar_email_text }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_email_link">Link Email</label>
                                            <input class="form-control" name="topbar_email_link" value="{{ $setting->topbar_email_link }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_phone_icon">Icon Telephone</label>
                                            <input class="form-control" name="topbar_phone_icon" value="{{ $setting->topbar_phone_icon }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_phone_text">Text Telephone</label>
                                            <input class="form-control" name="topbar_phone_text" value="{{ $setting->topbar_phone_text }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="topbar_phone_link">Link Phone</label>
                                            <input class="form-control" name="topbar_phone_link" value="{{ $setting->topbar_phone_link }}">
                                        </div>
                                    </div>
                                </div>

                                <h5 class="font-bolder mt-4 fs-4">Navigasi Logo</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sitename_text">Judul Halaman</label>
                                            <input class="sitename_text" name="sitename_text" value="{{ $setting->sitename_text }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sitename_href">Judul Halaman</label>
                                            <input class="sitename_href" name="sitename_href" value="{{ $setting->sitename_href }}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection
