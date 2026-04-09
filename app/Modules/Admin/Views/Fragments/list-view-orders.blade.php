@props(['val' => null, 'list' => null])

{{-- <a title="Cập nhật trạng thái đơn hàng" 
    data-toggle="modal" href="javascript:void(0);"
    data-target="#varyingcontentModal" data-whatever="@mdo" 
    class="btn btn-primary btn-sm">
    <i class="ri ri-file-edit-line" aria-hidden="true"></i>
</a>
<!-- Varying modal content -->
<div class="modal fade" id="varyingcontentModal" tabindex="-1" aria-labelledby="varyingcontentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="text-left text-start"> 
                    <div class="mb-3">
                        {{ csrf_field() }}
                        <label for="order_status_id" class="col-form-label">Trạng thái:</label>
                        {{Form::select("order_status_id", $list['order_status_id']['data'] , $val['order_status_id'], 
                            array('class' => 'form-control', 'id'=>"order_status_id", 'onchange'=>"selectStorage(this)"))}}
                    </div>
                    <div class="mb-3 text-left">
                        <label for="order_note" class="col-form-label">Ghi chú:</label>
                        {{Form::textarea("order_status_note", $val['order_status_note'], 
                            array('class' => 'form-control', 'id'=>"order_status_note"))}}
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="change_order_status_submit"
                    url="{{ route('orders-detail', $val['id']) }}"
                >Lưu</button>
            </div>
        </div>
    </div>
</div> --}}

<a title="Xem" href="{{route('orders-detail', $val['id'])}}" class="btn btn-success btn-sm">
    <i class="ri ri-file-list-line" aria-hidden="true"></i>
</a>

