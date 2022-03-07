@csrf
<div class="row">
    @foreach($menus as $menu)
        <div class="col-md-3">
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <label class="form-check-label">
                        <input type="checkbox" value="{{$menu->id}}" @if(in_array($menu->id, $permissions)) checked @endif class="form-check-input" name="permissions[]" /><span class="form-check-sign">&nbsp;&nbsp;&nbsp;{{$menu->name}}</span>
                    </label>
                </div>
            </div>
        </div>
    @endforeach
</div>