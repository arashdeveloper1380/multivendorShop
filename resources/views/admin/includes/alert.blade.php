@if (Session::has('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $model }} {{ Session::get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
      </div>

@elseif (Session::has('warning'))

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $model }} {{ Session::get('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (Session::has('danger'))

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $model }} {{ Session::get('danger') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@elseif (Session::has('restore'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $model }} {{ Session::get('restore') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

@endif
