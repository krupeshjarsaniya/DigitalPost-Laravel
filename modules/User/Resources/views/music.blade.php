@extends('admin.layouts.app')
@section('title', 'Music')
@section('content')
<style type="text/css">
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="page-header">
    <h4 class="page-title">Music</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Music</a>
        </li>
    </ul>
</div>
@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<div class="text-right mb-3">
    <a href="{{ route('musicCategory') }}" class="btn btn-danger text-white">Back</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $category->name }} Musics
                <button class="btn btn-info btn-sm pull-right" id="add-music"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="display table table-striped table-hover text-center w-100" id="music-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Audio</th>
                            <th>Duration</th>
                            <th>Language</th>
                            <th>Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-music-modal" tabindex="-1" role="dialog" aria-labelledby="addMusicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMusicModalLabel">Add Music</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="add-music-form" name="addMusicForm" onsubmit="return false;" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="category_id" name="category_id" value="{{ $category->id }}" />
                    <div class="row">
                        <div class="col-6 form-group err_name">
                            <label for="name">Name</label>
                            <input type"text" name="name" id="name" class="form-control" placeholder="Enter Music Name" />
                        </div>
                        <div class="col-6 form-group err_language_id">
                            <label for="language_id">Language</label>
                            <select name="language_id" id="language_id" class="form-control">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language )
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group err_image">
                            <label for="image">Image</label>
                            <input type="file" id="image" name="image" class="form-control" accept="image/*" />
                        </div>
                        <div class="col-6 form-group err_audio">
                            <label for="audio">Audio</label>
                            <input type="file" id="audio" name="audio" class="form-control" accept="audio/*" />
                        </div>
                        <div class="col-6 form-group err_duration">
                            <label for="duration">Duration</label>
                            <input type"text" name="duration" id="duration" class="form-control" placeholder="Enter Music Duration" />
                        </div>
                        <div class="col-6 form-group err_order_number">
                            <label for="order_number">Order</label>
                            <input type="text" id="order_number" name="order_number" placeholder="Enter Order" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"  onclick="addMusic()">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="edit-music-modal" tabindex="-1" role="dialog" aria-labelledby="editMusicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Music</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-music-form" name="editMusicForm" method="post" onsubmit="return false" enctype="multipart/form-data" >
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id" value="" />
                    <div class="row">
                        <div class="col-6 form-group err_name" >
                            <label for="edit_name">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter Name" />
                        </div>
                        <div class="col-6 form-group err_language_id">
                            <label for="edit_language_id">Language</label>
                            <select name="language_id" id="edit_language_id" class="form-control">
                                <option value="">Select Language</option>
                                @foreach ($languages as $language )
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group err_image">
                            <label for="edit_image">Image</label>
                            <input type="file" name="image" id="edit_image" class="form-control" accept="image/*" />
                        </div>
                        <div class="col-6 form-group err_audio">
                            <label for="edit_audio">Audio</label>
                            <input type="file" name="audio" id="edit_audio" class="form-control" accept="audio/*" />
                        </div>
                        <div class="col-6 form-group err_duration">
                            <label for="duration">Duration</label>
                            <input type"text" name="duration" id="edit_duration" class="form-control" placeholder="Enter Music Duration" />
                        </div>
                        <div class="col-6 form-group err_order_number">
                            <label for="edit_order_number">Order</label>
                            <input type="text" id="edit_order_number" name="order_number" placeholder="Enter Order" class="form-control" />
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-success"  onclick="updateMusic()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript" src="{{ url('/public/admin/js/user/music.js?v='.rand()) }}"></script>
@endsection
