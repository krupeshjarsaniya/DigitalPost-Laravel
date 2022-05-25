@extends('admin.layouts.app')
@section('title', 'BG Remove Plan')
@section('content')
<div class="page-header">
    <h4 class="page-title">BG Remove Plan</h4>
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
            <a href="#">BG Remove Plan</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">BG Remove Plan List
                <button class="btn btn-info btn-sm pull-right" id="add-bg-remove-plan"><i class="fas fa-plus"></i></button>
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-hover text-center" id="bg-remove-plan-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Credit</th>
                                <th>Order</th>
                                <th>Status</th>
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
</div>

<div class="modal fade" id="add-bg-remove-plan-modal" tabindex="-1" role="dialog" aria-labelledby="addBGRemovePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addBGRemovePlanModalLabel">Add BG Remove Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" onsubmit="return false" name="addBGRemovePlanForm" id="addBGRemovePlanForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 form-group err_name">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required />
                        </div>
                        <div class="col-6 form-group err_price">
                            <label for="price">Price</label>
                            <input type="text" name="price" id="price" class="form-control" placeholder="Enter Price" required />
                        </div>
                        <div class="col-6 form-group err_bg_credit">
                            <label for="bg_credit">BG Remove Credit</label>
                            <input type="text" name="bg_credit" id="bg_credit" class="form-control" placeholder="Enter Credit" required />
                        </div>
                        <div class="col-6 form-group err_order_number">
                            <label for="order_number">Order</label>
                            <input type="text" name="order_number" id="order_number" class="form-control" placeholder="Enter Order" />
                        </div>
                        <div class="col-6 form-group err_status">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control" required >
                                <option value="">Select Status</option>
                                <option value="UNBLOCK">Unblock</option>
                                <option value="BLOCK">Block</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer" >
                <button class="btn btn-success" type="submit" onclick="addBGRemovePlanFun()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="edit-bg-remove-plan-modal" tabindex="-1" role="dialog" aria-labelledby="editBGRemovePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addBGRemovePlanModalLabel">Edit BG Remove Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" onsubmit="return false" name="editBGRemovePlanForm" id="editBGRemovePlanForm">
                <input type="hidden" name="id" id="edit_id" value="" />
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 form-group err_name">
                            <label for="edit_name">Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter name" />
                        </div>
                        <div class="col-6 form-group err_price">
                            <label for="edit_price">Price</label>
                            <input type="text" name="price" id="edit_price" class="form-control" placeholder="Enter price" />
                        </div>
                        <div class="col-6 form-group err_bg_credit">
                            <label for="edit_bg_credit">BG Remove Credit</label>
                            <input type="text" name="bg_credit" id="edit_bg_credit" class="form-control" placeholder="Enter Credit" required />
                        </div>
                        <div class="col-6 form-group err_order_number">
                            <label for="edit_order_number">Order</label>
                            <input type="text" name="order_number" id="edit_order_number" class="form-control" placeholder="Enter Order" />
                        </div>
                    </div>
                </div>
            </form>

            <div class="modal-footer" >
                <button class="btn btn-success" type="submit" onclick="updateBGRemovePlanFun()">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

@endsection
@section('js')
    <script type="text/javascript" src="{{ url('/public/admin/js/user/bgRemovePlan.js?v='.rand()) }}"></script>
@endsection
