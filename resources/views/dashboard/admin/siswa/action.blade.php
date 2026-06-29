<div class="form-button-action">
    <!-- Button Lihat -->
    <a href="{{ route('dashboard.siswa.show', $row->id) }}" 
       class="btn btn-link btn-info btn-lg p-2 btn-show-detail" 
       data-bs-toggle="tooltip" 
       title="Lihat Detail">
        <i class="fa fa-eye"></i>
    </a>
    
    <!-- Button Edit -->
    <a href="{{ route('dashboard.siswa.edit', $row->id) }}" 
       class="btn btn-link btn-primary btn-lg p-2" 
       data-bs-toggle="tooltip" 
       title="Edit">
        <i class="fa fa-edit"></i>
    </a>

    <!-- Button Hapus -->
    <form action="{{ route('dashboard.siswa.destroy', $row->id) }}" 
          method="POST" 
          class="d-inline form-delete-row">
        @csrf
        @method('DELETE')
        <button type="button" 
                class="btn btn-link btn-danger btn-lg p-2 btn-delete-row" 
                data-bs-toggle="tooltip" 
                title="Hapus">
            <i class="fa fa-times"></i>
        </button>
    </form>
</div>
