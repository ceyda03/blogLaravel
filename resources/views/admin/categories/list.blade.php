@extends("layouts.admin")
@section("title")
    Kategori Listeleme
@endsection

@section("css")
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
            <h2>Kategori Listesi</h2>
        </x-slot:header>
        <x-slot:body>
            <x-bootstrap.table
                :class="'table-striped table-hover'"
                :is-responsive="1"
            >
                <x-slot:columns>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feature Status</th>
                    <th scope="col">Description</th>
                    <th scope="col">Order</th>
                    <th scope="col">Parent Category</th>
                    <th scope="col">User</th>
                    <th scope="col">Actions</th>
                </x-slot:columns>

                <x-slot:rows>
                    @foreach($list as $category)
                        <tr>
                            <th scope="row">{{ $category->name }}</th>
                            <td>{{ $category->slug }}</td>
                            <td>
                                @if($category->status)
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-success btn-sm btnChangeStatus">Aktif</a>
                                @else
                                    <a href="javascript:void(0)" data-id="{{ $category->id }}" class="btn btn-danger btn-sm btnChangeStatus">Pasif</a>
                                @endif
                            </td>
                            <td>
                                @if($category->feature_status)
                                    Aktif
                                @else
                                    Pasif
                                @endif
                            </td>
                            <td>{{ substr($category->description, 0, 20) }}</td>
                            <td>{{ $category->order }}</td>
                            <td>{{ $category->parentCategory?->name }}</td>
                            <td>{{ $category->user?->name }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-warning"><i class="material-icons ms-0">edit</i></a>
                                <a href="javascript:void(0)" class="btn btn-danger"><i class="material-icons ms-0">delete</i></a>
                            </td>
                        </tr>
                    @endforeach
                </x-slot:rows>
            </x-bootstrap.table>
        </x-slot:body>
    </x-bootstrap.card>
    <form action="" method="POST" id="statusChangeForm">
        @csrf
        <input type="hidden" name="id" id=inputStatus" value="">
        <input type="hidden" name="idValue" id=idValue" value="0">
    </form>
@endsection

@section("js")
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
                        $('#idValue').val("1");
                       // $('#statusChangeForm').submit();
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
        })
    </script>
@endsection
