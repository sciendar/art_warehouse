@php
    $files = \App\Models\Image::get_i_images();
@endphp

<div class="row justify-content-center">
    <div class="col-auto mb-3">
        <button type="button" class="btn btn-outline-success btn-sm add-image" data-bs-toggle="modal" data-bs-target="#images_image">
            <i class="fas fa-plus"></i> Додати зображення
        </button>
    </div>
</div>

<form action="{{ isset($item) ? route($route . '.update', $item) : route($route . '.store') }}" class="was-validated" method="POST" enctype="multipart/form-data">
    @isset($item) @method('PATCH') @endisset
    @csrf
    <!-- Modal -->
    <div class="modal fade" id="images_image" tabindex="-1" aria-labelledby="images_image_label" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="images_image_label">Select image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="min-height: 220px">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="alt">
                                Alt
                                <span class="text-primary x-3" data-tooltip="tooltip" title="alt">
                                <i class="fas fa-search"></i>
                            </span>
                            </label>
                            <input type="text" name="alt" class="form-control" id="alt">
                        </div>
                        <div class="col">
                            <label for="period">Період</label>
                            <input type="text" name="period" class="form-control" id="period">
                        </div>
                        <div class="col-auto">
                            <label><br></label>
                            <button type="button" class="btn btn-outline-primary btn-block mt-4" id="search_images">
                                Пошук
                            </button>
                        </div>
                    </div>
                    <div id="pagination_container" class="d-flex justify-content-center mt-3">
                        @if($files->hasPages())
                            @include('admin._includes._image_pagination', ['paginate'=>$files])
                        @endif
                    </div>
                </div>
                <div class="modal-body text-left">
                    <div id="images_container">
                        @include('admin._includes._search_images')
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary confirm-selection">Додати</button>
                </div>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {
            click_search_files();
            click_paginate_files();
            select_image();

            // Обработка кнопки поиска
            function click_search_files () {
                $('#search_images').on('click', function() {
                    load_images();
                });
            }

            // Обработка пагинации
            function click_paginate_files() {
                document.querySelectorAll('.page_link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();

                        const page = this.getAttribute('data-page');
                        if (!page) return;

                        console.log('Выбрана страница:', page);
                        load_images(page);
                    });
                });
            }

            // Функция загрузки изображений
            async function load_images(page = 1) {
                let alt = $('#alt').val();
                let period = $('#period').val();
                console.log(alt);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        alt: alt,
                        period: period,
                        page: page,
                    },
                    type: "POST",
                    url: @json(route('js.get_i_images')),
                    success: async function (response) {
                        console.log(response);
                        $('#images_container').html(response.images_html);
                        $('#pagination_container').html(response.pagination_html);

                        click_search_files();
                        click_paginate_files();
                        select_image();
                    },
                    error:   function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }


            function select_image() {
                // Текущее выбранное изображение в модальном окне
                let selectedImage = null;
                // Элемент для замены изображения
                let currentReplacement = null;
                let currentImageId = null;

                // Обработчик клика по карточкам изображений в модальном окне
                document.querySelectorAll('#images_image .image-select-card').forEach(card => {
                    card.addEventListener('click', function() {
                        document.querySelectorAll('#images_image .image-select-card').forEach(c => {
                            c.style.border = '1px solid #ddd';
                        });
                        this.style.border = '2px solid #007bff';
                        selectedImage = {
                            id: this.dataset.imageId,
                            src: this.dataset.imageSrc
                        };
                    });
                });

                // Обработчик открытия модального окна для замены изображения
                document.querySelectorAll('.change-image').forEach(btn => {
                    btn.addEventListener('click', function() {
                        currentReplacement = this.closest('.image-preview-wrapper');
                        currentImageId = this.dataset.currentImage;

                        document.querySelectorAll('#images_image .image-select-card').forEach(c => {
                            c.style.border = '1px solid #ddd';
                        });
                        selectedImage = null;

                        const currentImg = currentReplacement.querySelector('img');
                        const currentSrc = currentImg.src;

                        document.querySelectorAll('#images_image img').forEach(img => {
                            if (img.src === currentSrc) {
                                img.closest('.image-select-card').style.border = '2px solid #007bff';
                                selectedImage = {
                                    id: img.closest('.image-select-card').dataset.imageId,
                                    src: currentSrc
                                };
                            }
                        });
                    });
                });

                // Обработчик открытия модального окна для добавления нового изображения
                document.querySelector('.add-image').addEventListener('click', function() {
                    document.querySelectorAll('#images_image .image-select-card').forEach(c => {
                        c.style.border = '1px solid #ddd';
                    });
                    selectedImage = null;
                    currentReplacement = null;
                });

                // Кнопка подтверждения выбора
                document.querySelector('#images_image .confirm-selection').addEventListener('click', function() {
                    if (selectedImage) {
                        if (currentReplacement) {
                            replaceImage(currentReplacement, selectedImage.src, selectedImage.id);
                            currentReplacement = null;
                        } else {
                            addImagePreview(selectedImage.src, selectedImage.id);
                        }
                        $('#images_image').modal('hide');
                        selectedImage = null;
                    }
                });



                // Обработчики удаления для существующих изображений
                document.querySelectorAll('.remove-image').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const wrapper = this.closest('.image-preview-wrapper');
                        if (document.querySelectorAll('.image-preview-wrapper').length > 1) {
                            wrapper.remove();
                            updateImageIndexes();
                        } else {
                            const img = wrapper.querySelector('img');
                            const input = wrapper.querySelector('input');
                            img.src = "{{ asset('admin/img/no_image.jpg') }}";
                            input.value = '';
                            wrapper.querySelector('.change-image').dataset.currentImage = '0';
                        }
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {

                });
            }

            // Функция замены изображения
            function replaceImage(wrapper, src, id) {
                wrapper.querySelector('img').src = src;
                wrapper.querySelector('input').value = id;
                wrapper.querySelector('.change-image').dataset.currentImage = id;
            }

            // Функция добавления нового изображения с использованием шаблона
            function addImagePreview(src, id) {
                const container = document.querySelector('.images-container');
                const template = document.getElementById('image-template');
                const clone = template.content.cloneNode(true);
                const wrapper = clone.querySelector('.image-preview-wrapper');
                const index = document.querySelectorAll('.image-preview-wrapper').length;

                // Заполняем шаблон данными
                wrapper.dataset.imageIndex = index;
                wrapper.querySelector('img').src = src;
                wrapper.querySelector('input').name = `images[${index}]`;
                wrapper.querySelector('input').value = id;
                wrapper.querySelector('.change-image').dataset.currentImage = id;

                // Добавляем обработчики событий
                const removeBtn = wrapper.querySelector('.remove-image');
                removeBtn.addEventListener('click', function() {
                    if (document.querySelectorAll('.image-preview-wrapper').length > 1) {
                        wrapper.remove();
                        updateImageIndexes();
                    } else {
                        // Сброс на дефолтное изображение
                        wrapper.querySelector('img').src = "{{ asset('admin/img/no_image.jpg') }}";
                        wrapper.querySelector('input').value = '';
                        wrapper.querySelector('.change-image').dataset.currentImage = '0';
                    }
                });

                const changeBtn = wrapper.querySelector('.change-image');
                changeBtn.addEventListener('click', function() {
                    currentReplacement = wrapper;
                    document.querySelectorAll('#images_image .image-select-card').forEach(c => {
                        c.style.border = '1px solid #ddd';
                    });

                    const currentImg = wrapper.querySelector('img');
                    const currentSrc = currentImg.src;

                    document.querySelectorAll('#images_image img').forEach(img => {
                        if (img.src === currentSrc) {
                            img.closest('.image-select-card').style.border = '2px solid #007bff';
                            selectedImage = {
                                id: img.closest('.image-select-card').dataset.imageId,
                                src: currentSrc
                            };
                        }
                    });
                });

                container.appendChild(clone);
            }

            // Обновление индексов после удаления
            function updateImageIndexes() {
                document.querySelectorAll('.image-preview-wrapper').forEach((wrapper, index) => {
                    wrapper.dataset.imageIndex = index;
                    const input = wrapper.querySelector('input');
                    input.name = `images[${index}]`;
                });
            }
        });
    </script>

    <script>
        $('#period').daterangepicker({
            "showDropdowns": true,
            "minYear": 2000,
            "maxYear": @json((int) now()->format('Y')),
            ranges: {
                'Today': [moment().startOf('day'), moment().endOf('day')],
                'Yesterday': [moment().subtract(1, 'day').startOf('day'), moment().subtract(1, 'day').endOf('day')],
                'Week to date': [moment().startOf('week'), moment().endOf('week')],
                'Last week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                'Month to date': [moment().startOf('month'), moment().endOf('month')],
                'Last month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Quarter to date': [moment().startOf('quarter'), moment().endOf('quarter')],
                'Last quarter': [moment().subtract(1, 'quarter').startOf('quarter'), moment().subtract(1, 'quarter').endOf('quarter')],
                'Year to date': [moment().startOf('year'), moment().endOf('year')],
                'Last year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            },
            "locale": {
                "format": "DD.MM.YYYY",
                "separator": " - ",
                "applyLabel": "Select",
                "cancelLabel": "Cancel",
                "fromLabel": "From",
                "toLabel": "To",
                "customRangeLabel": "Own choice",
                "weekLabel": "W",
                "daysOfWeek": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                "monthNames": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                "firstDay": 1
            },
            "startDate": @json(\Carbon\Carbon::createFromFormat('d.m.Y', (isset($_GET['period']) ? Str::before($_GET['period'], ' - ') : '01.01.1970'))->format('d.m.Y')),
            "endDate": @json((isset($_GET['period']) ? \Carbon\Carbon::createFromFormat('d.m.Y', Str::after($_GET['period'], ' - ')) : now())->format('d.m.Y')),
            "minDate": "01/01/1970",
            "maxDate": @json(now()->format('d.m.Y')),
            "opens": "center"
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });
    </script>
@endpush

@push('styles')
    <style>
        .image-select-card:hover {
            background-color: #f8f9fa;
        }
        .image-actions .btn {
            padding: 0.25rem;
            width: 24px;
            height: 24px;
            font-size: 0.7rem;
        }
        .image-actions .btn-sm {
            line-height: 1;
        }
    </style>
@endpush
