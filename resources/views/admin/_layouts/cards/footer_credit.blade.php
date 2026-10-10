<div class="card-footer">
    <div class="row justify-content-end">
        <div class="col-auto text-end">
            @if(($show_is_active ?? true) == true)
                <div class="form-check form-switch d-inline">
                    <input class="form-check-input mt-2 mx-0" type="checkbox" name="is_active" id="is_active" @checked(empty($item) || $item->is_active == true)>
                    <label class="form-check-label" for="is_active"></label>
                </div>
            @endif
            <button type="submit" class="btn btn-outline-primary d-inline btn-sm">
                Сохранить
            </button>
        </div>
    </div>
</div>
