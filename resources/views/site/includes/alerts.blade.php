@if(session('success'))
    <div id="alert" class="alert alert-success">
           {{session('success')}} 
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
    </div>
@endif

@if(session('Errors'))
    <div id="alert" class="alert alert-danger">
        {{session('Errors')}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
			    <span aria-hidden="true">&times;</span>
			  </button>
    </div>
@endif
