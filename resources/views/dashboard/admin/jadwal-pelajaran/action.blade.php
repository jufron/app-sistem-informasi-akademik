<div class="form-button-action">
    <!-- Button Show -->
    <button type="button"
            class="btn btn-link btn-info btn-lg p-2 btn-show-row"
            data-id="{{ $row->id }}"
            data-bs-toggle="tooltip"
            title="Detail Jadwal">
        <i class="fa fa-eye"></i>
    </button>

    <!-- Button Edit -->
    <a href="{{ route('dashboard.jadwal-pelajaran.edit', $row->id) }}" 
       class="btn btn-link btn-primary btn-lg p-2" 
       data-bs-toggle="tooltip" 
       title="Edit Jadwal">
        <i class="fa fa-edit"></i>
    </a>

    <!-- Button Hapus -->
    <form action="{{ route('dashboard.jadwal-pelajaran.destroy', $row->id) }}" 
          method="POST" 
          class="d-inline form-delete-row">
        @csrf
        @method('DELETE')
        <button type="button" 
                class="btn btn-link btn-danger btn-lg p-2 btn-delete-row" 
                data-bs-toggle="tooltip" 
                title="Hapus Jadwal">
            <i class="fa fa-times"></i>
        </button>
    </form>
</div>
