@extends("layouts.admin")
@section("title")
    Makale Listeleme
@endsection

@section("css")
    <link rel="stylesheet" href="{{ asset("assets/admin/plugins/flatpickr/flatpickr.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/admin/plugins/select2/css/select2.min.css") }}">
    <style>
        .table-hover > tbody > tr:hover {
            --bs-table-hover-bg: transparent;
            background: #363638;
            color: #fff;
        }
    </style>
@endsection

@section("content")
    <x-bootstrap.card>
        <x-slot:header>
            <h2>Makale Listesi</h2>
        </x-slot:header>

        <x-slot:body>
            <form action="">
                <div class="row">
                    <div class="col-3 my-2">
                        <select class="js-states form-control" tabindex="-1" id="selectParentCategory" name="category_id" style="display: none; width: 100%;" >
                            <option value="{{ null }}">Kategori Seçin</option>
                            @foreach($categories as $parent)
                                <option value="{{ $parent->id }}" {{ request()->get("parent_id") == $parent->id ? "selected" : "" }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="user_id">
                            <option value="{{ null }}">Users</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request()->get("user_id") == $user->id ? "selected" : "" }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <select class="form-select" name="status" aria-label="Status" >
                            <option value="{{ null }}">Status</option>
                            <option value="0" {{ request()->get("status") === "0" ? "selected" : "" }}>Pasif</option>
                            <option value="1" {{ request()->get("status") === "1" ? "selected" : "" }}>Aktif</option>
                        </select>
                    </div>
                    <div class="col-3 my-2">
                        <input type="text"
                               class="form-control flatpickr2 m-b-sm"
                               id="publish_date"
                               name="publish_date"
                               value="{{ request()->get("publish_date") }}"
                               placeholder="Ne zaman yayınlansın?">
                    </div>
                    <div class="col-3 my-2">
                        <input type="text" class="form-control" placeholder="Title, Slug, Body, Tags" name="search_text" value="{{ request()->get("search_text") }}">
                    </div>
                    <div class="col-9 my-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Min View Count" name="min_view_count" value="{{ request()->get("min_view_count") }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Max View Count" name="max_view_count" value="{{ request()->get("max_view_count") }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Min Like Count" name="min_like_count" value="{{ request()->get("min_like_count") }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" placeholder="Max Like Count" name="max_like_count" value="{{ request()->get("max_like_count") }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-6 mb-3 d-flex">
                        <button class="btn btn-primary w-50 me-4" type="submit">Filtrele</button>
                        <button class="btn btn-warning w-50" type="submit">Filtreyi Temizle</button>
                    </div>
                    <hr>
                </div>
            </form>
            <x-bootstrap.table
                :class="'table-striped table-hover'"
                :is-responsive="1"
            >
                <x-slot:columns>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Body</th>
                    <th scope="col">Tags</th>
                    <th scope="col">View Count</th>
                    <th scope="col">Like Count</th>
                    <th scope="col">Category</th>
                    <th scope="col">Publish Date</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach($list as $article)
                        <tr>
                            <td>
                                @if(!empty($article->image))
                                    <img src="{{ asset($article->image) }}" height="100" class="img-fluid">
                                @endif
                            </td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->slug }}</td>
                            <td>
                                @if($article->status)
                                    <a href="javascript:void(0)" class="btn btn-success btn-sm btnChangeStatus" data-id="{{ $article->id }}">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm btnChangeStatus" data-id="{{ $article->id }}">Pasif</a>
                                @endif
                            </td>
                            <td>
                                <span data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{ substr($article->body, 0, 200) }}">
                                    {{ substr($article->body, 0, 20) }}
                                </span>
                            </td>
                            <td>{{ $article->tags }}</td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->like_count }}</td>
                            <td>{{ $article->category->name }}</td>
                            <td>{{ $article->user->name }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-warning btn-sm"><i class="material-icons ms-0">edit</i></a>
                                <a href="javascript:void(0)" class="btn btn-danger btn-sm btnDelete"
                                   data-name="{{ $article->title }}"
                                   data-id="{{ $article->id }}">
                                    <i class="material-icons ms-0">delete</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
            <div class="d-flex justify-content-center">
                {{--                {{ $list->links("vendor.pagination.bootstrap-5") }}--}}
                {{--                {{ $list->onEachside(1)->links() }}--}}
                {{--                @php--}}
                {{--                    $filterArray = ["name" => request()->get("name"), "description" => request()->get("description")]--}}
                {{--                @endphp--}}
                {{--                {{ $list->appends($filterArray)->onEachside(2)->links() }}--}}
                {{--                {{ $list->appends($_GET)->onEachside(2)->links() }}--}}
                {{ $list->appends(request()->all())->onEachside(2)->links() }}
            </div>
        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id="inputStatus" value="">
    </form>
@endsection

@section("js")
    <script src="{{ asset("assets/admin/plugins/select2/js/select2.full.min.js") }}"></script>
    <script src="{{ asset("assets/admin/js/pages/select2.js") }}"></script>
    <script src="{{ asset("assets/admin/plugins/flatpickr/flatpickr.js") }}"></script>
    <script src="{{ asset("assets/admin/js/pages/datepickers.js") }}"></script>
    <script src="{{ asset("assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset("assets/admin/plugins/bootstrap/js/popper.min.js") }}"></script>
    <script>
        $(document).ready(function () {
            $('.btnChangeStatus').click(function () {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: "Status değiştirmek istediğinize emin misiniz?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Evet",
                    denyButtonText: "Hayır",
                    cancelButtonText: "İptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action", "{{ route('categories.changeStatus') }}");
                        $('#statusChangeForm').submit();
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir işlem yapılmadı",
                            confirmButtonText: "Evet",
                            icon: "info"
                        })
                    }
                });
            })

            $('.btnChangeFeatureStatus').click(function () {
                let categoryID = $(this).data('id');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: "Feature Status değiştirmek istediğinize emin misiniz?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Evet",
                    denyButtonText: "Hayır",
                    cancelButtonText: "İptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action", "{{ route('categories.changeFeatureStatus') }}");
                        $('#statusChangeForm').submit();
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir işlem yapılmadı",
                            confirmButtonText: "Evet",
                            icon: "info"
                        })
                    }
                });
            })

            $('.btnDelete').click(function () {
                let categoryID = $(this).data('id');
                let categoryName = $(this).data('name');
                $('#inputStatus').val(categoryID);

                Swal.fire({
                    title: categoryName + " silmek istediğinize emin misiniz?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Evet",
                    denyButtonText: "Hayır",
                    cancelButtonText: "İptal"
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#statusChangeForm').attr("action", "{{ route('categories.delete') }}");
                        $('#statusChangeForm').submit();
                    } else if (result.isDenied) {
                        Swal.fire({
                            title: "Bilgi",
                            text: "Herhangi bir işlem yapılmadı",
                            confirmButtonText: "Evet",
                            icon: "info"
                        })
                    }
                });
            })

            $('#selectParentCategory').select2();
        })
    </script>
    <script>
        $('#publish_date').flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
        });
    </script>
@endsection
