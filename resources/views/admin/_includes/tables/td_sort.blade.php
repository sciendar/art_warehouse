<a href="#" data-bs-toggle="modal" data-bs-target="#modal_sort">
    <span data-bs-toggle="tooltip" title="Порядок">
        <i class="bi bi-list-ol"></i>
        @if($item->index != 9999)<sup>{{ $item->index }}</sup>@endif
    </span>
</a>

@php
    $sort_title = $sort_title ?? 'title';
@endphp

@once
    <div class="modal fade" id="modal_sort">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route($route . '.sort') }}" class="was-validated" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="sort" id="sort">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_sort_home_showLabel">Порядок отображения</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left">
                        <ul class="todo-list ui-sortable" data-widget="todo-list">
                            @foreach($items->sortBy('index') as $item)
                                <li class="done">
                                    <span class="handle ui-sortable-handle">
                                        <i class="fas fa-ellipsis-v"></i>
                                        <i class="fas fa-ellipsis-v"></i>
                                        <input type="hidden" class="sort" name="sort[]" value="{{ $item->id }}">
                                    </span>
                                    <div class="icheck-primary d-inline ml-2">
                                        {{ $item->$sort_title }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-primary ml-4" id="IN_BLOCK">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // $(document).on('click','#IN_BLOCK',function (){
        //     let data_sort = document.getElementsByClassName('sort');
        //     let sort = document.getElementById('sort');
        //
        //     let arr_sort = [];
        //     for (let i = 0; i < data_sort.length; i++) {
        //         arr_sort[i] = data_sort[i].defaultValue;
        //     }
        //     sort.value = arr_sort;
        //     let IN_BLOCK = document.getElementById('IN_BLOCK');
        //     IN_BLOCK.setAttribute('type', 'submit');
        //     IN_BLOCK.click();
        // });
    </script>
@endonce
