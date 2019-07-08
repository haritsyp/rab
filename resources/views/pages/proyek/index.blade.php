@extends('layouts.app')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('proyek.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Tambah</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelku" class="table table-bordered">
                <thead>
                    <tr>
                        <th width="60px">ID</th>
                        <th>Nama Proyek</th>
                        <th>Biaya</th>
                        <th>Lama</th>
                        <th width="128px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proyek as $d)
                    <tr>
                        <td>{{ $d->id_proyek }}</td>
                        <td>{{ $d->nama_proyek }}</td>
                        <td>{{ $d->biaya_proyek }}</td>
                        <td>{{ $d->lama }}</td>
                        <td>
                            <a href="{{ route('proyek.edit',$d->id_proyek) }}" class="btn-sm btn-primary"><i class="fa fa-pencil-alt"></i> Ubah</a>
                            <a href="javascript:void(0)" class="delete btn-sm btn-danger" data-id="{{ $d->id_proyek }}"><i class="fa fa-trash-alt"></i> Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#tabelku').DataTable();
    });

    $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "Apakah anda yakin?",
                text: "Setelah data dihapus data tidak akan bisa dikembalikan!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('proyek') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (data) {
                            window.location = "{{ url('proyek') }}"
                        }         
                    });
                }
            });
        });
</script>
@endsection
