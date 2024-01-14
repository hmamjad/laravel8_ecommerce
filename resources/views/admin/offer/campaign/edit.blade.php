<form action="{{ route('campaign.store') }}" method="post" id="add-form" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">

        {{-- Campaign   --}}
        <div class="form-group">
            <label for="title">Campaign Title <span class="text-danger">*</span> </label>
            <input type="text" class="form-control" id="title" name="title" required="">
            <small id="emailHelp" class="form-text text-muted">This is Campaign Title/Name</small>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="start_date">Start Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required="">
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="end_date">End Date<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required="">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="status">Status<span class="text-danger">*</span></label>
                <select  class="form-control" id="status" name="status" required="">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="discount">Discount(%)<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="discount" name="discount" required="">
                    <small id="emailHelp" class="form-text text-danger">Discount percentage are apply for all procuct selling price</small>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="input-file-now">Image<span class="text-danger">*</span></label>
            <input type="file" class="form-control dropify" data-height='140' id="input-file-now"
                name="image" required="">
            <small id="emailHelp" class="form-text text-muted">This is your Campaign Image</small>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"> <span class="d-none">loading.........</span>
            Submit</button>
    </div>
</form>